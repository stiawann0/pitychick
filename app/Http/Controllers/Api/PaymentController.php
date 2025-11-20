<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Log;
use App\Models\Order;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Setup Midtrans configuration
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production', false);
        Config::$isSanitized = config('services.midtrans.is_sanitized', true);
        Config::$is3ds = config('services.midtrans.is_3ds', true);
    }

    public function createMidtransTransaction(Request $request)
    {
        try {
            Log::info('Midtrans Transaction Request:', $request->all());

            // Validasi input
            $validated = $request->validate([
                'order_id' => 'required|string|max:255',
                'gross_amount' => 'required|integer|min:1',
                'customer_name' => 'required|string|max:255',
                'customer_email' => 'required|email|max:255',
                'customer_phone' => 'required|string|max:255',
                'item_details' => 'required|array|min:1',
                'item_details.*.id' => 'required|string',
                'item_details.*.name' => 'required|string|max:255',
                'item_details.*.price' => 'required|integer|min:0',
                'item_details.*.quantity' => 'required|integer|min:1',
            ]);

            // Validasi total amount
            $calculatedTotal = 0;
            foreach ($validated['item_details'] as $item) {
                $calculatedTotal += ($item['price'] * $item['quantity']);
            }

            if ($calculatedTotal !== $validated['gross_amount']) {
                return response()->json([
                    'success' => false,
                    'message' => "Total item price ({$calculatedTotal}) tidak sama dengan gross_amount ({$validated['gross_amount']})"
                ], 400);
            }

            // Siapkan parameter transaksi
            $transactionParams = [
                'transaction_details' => [
                    'order_id' => $validated['order_id'],
                    'gross_amount' => $validated['gross_amount'],
                ],
                'customer_details' => [
                    'first_name' => $validated['customer_name'],
                    'email' => $validated['customer_email'],
                    'phone' => $validated['customer_phone'],
                ],
                'item_details' => $validated['item_details'],
                'callbacks' => [
                    'finish' => config('app.url') . '/payment/finish',
                    'error' => config('app.url') . '/payment/error',
                    'pending' => config('app.url') . '/payment/pending'
                ]
            ];

            Log::info('Midtrans Transaction Params:', $transactionParams);

            // Generate Snap Token
            $snapToken = Snap::getSnapToken($transactionParams);

            Log::info('Midtrans Snap Token Generated:', ['token' => $snapToken]);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'message' => 'Transaction created successfully',
                'order_id' => $validated['order_id']
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Error:', $e->errors());
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());
            Log::error('Midtrans Error Trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Midtrans error: ' . $e->getMessage(),
                'debug' => [
                    'server_key' => config('services.midtrans.server_key'),
                    'is_production' => config('services.midtrans.is_production'),
                    'order_id' => $request->order_id ?? 'null',
                    'gross_amount' => $request->gross_amount ?? 'null'
                ]
            ], 500);
        }
    }

    /**
     * Handle Midtrans notification webhook
     */
    public function notificationHandler(Request $request)
    {
        Log::info('🟢 MIDTRANS NOTIFICATION RECEIVED', $request->all());

        try {
            $notification = $request->all();
            
            // Validasi signature key untuk keamanan
            $serverKey = config('services.midtrans.server_key');
            $hashed = hash('sha512', 
                $notification['order_id'] . 
                $notification['status_code'] . 
                $notification['gross_amount'] . 
                $serverKey
            );

            if ($hashed != $notification['signature_key']) {
                Log::error('❌ Invalid Midtrans signature', [
                    'received' => $notification['signature_key'],
                    'calculated' => $hashed
                ]);
                return response()->json(['status' => 'error', 'message' => 'Invalid signature'], 401);
            }

            $orderId = $notification['order_id'];
            $transactionStatus = $notification['transaction_status'];
            $fraudStatus = $notification['fraud_status'] ?? '';

            Log::info('🟡 Processing payment update', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
                'fraud_status' => $fraudStatus
            ]);

            // Cari order berdasarkan order_id
            $order = Order::where('order_id', $orderId)->first();

            if (!$order) {
                Log::error('❌ Order not found for Midtrans notification', ['order_id' => $orderId]);
                return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
            }

            // Update status berdasarkan notifikasi Midtrans
            $updateData = [
                'midtrans_transaction_id' => $notification['transaction_id'],
                'payment_method' => $notification['payment_type'] ?? $order->payment_method,
            ];

            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    $updateData['payment_status'] = 'paid';
                    $updateData['status'] = 'confirmed';
                    $updateData['paid_at'] = now();
                    Log::info('✅ Payment captured successfully', ['order_id' => $orderId]);
                } else {
                    $updateData['payment_status'] = 'pending';
                    $updateData['status'] = 'pending';
                    Log::info('⏳ Payment captured but fraud check pending', ['order_id' => $orderId]);
                }
            } else if ($transactionStatus == 'settlement') {
                $updateData['payment_status'] = 'paid';
                $updateData['status'] = 'confirmed';
                $updateData['paid_at'] = now();
                Log::info('✅ Payment settled successfully', ['order_id' => $orderId]);
            } else if ($transactionStatus == 'pending') {
                $updateData['payment_status'] = 'pending';
                $updateData['status'] = 'pending';
                Log::info('⏳ Payment pending', ['order_id' => $orderId]);
            } else if ($transactionStatus == 'deny') {
                $updateData['payment_status'] = 'failed';
                $updateData['status'] = 'cancelled';
                $updateData['cancellation_reason'] = 'Payment denied by payment gateway';
                Log::info('❌ Payment denied', ['order_id' => $orderId]);
            } else if ($transactionStatus == 'expire') {
                $updateData['payment_status'] = 'expired';
                $updateData['status'] = 'cancelled';
                $updateData['cancellation_reason'] = 'Payment expired';
                Log::info('❌ Payment expired', ['order_id' => $orderId]);
            } else if ($transactionStatus == 'cancel') {
                $updateData['payment_status'] = 'cancelled';
                $updateData['status'] = 'cancelled';
                $updateData['cancellation_reason'] = 'Payment cancelled by user';
                Log::info('❌ Payment cancelled', ['order_id' => $orderId]);
            }

            $order->update($updateData);

            Log::info('✅ Order updated successfully', [
                'order_id' => $orderId,
                'new_status' => $order->status,
                'payment_status' => $order->payment_status
            ]);

            return response()->json(['status' => 'success', 'message' => 'Notification processed']);

        } catch (\Exception $e) {
            Log::error('❌ Error processing Midtrans notification: ' . $e->getMessage(), [
                'exception' => $e,
                'notification' => $request->all()
            ]);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Check payment status manually
     */
    public function checkPaymentStatus($orderId)
    {
        try {
            Log::info('🟡 Manual payment status check', ['order_id' => $orderId]);
            
            $serverKey = config('services.midtrans.server_key');
            $authString = base64_encode($serverKey . ':');
            
            $baseUrl = config('services.midtrans.is_production') 
                ? 'https://api.midtrans.com' 
                : 'https://api.sandbox.midtrans.com';
            
            $client = new \GuzzleHttp\Client();
            $response = $client->get("{$baseUrl}/v2/{$orderId}/status", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Basic ' . $authString,
                ],
                'timeout' => 10
            ]);

            $statusData = json_decode($response->getBody(), true);
            
            Log::info('🟡 Midtrans API response', $statusData);
            
            $order = Order::where('order_id', $orderId)->first();
            if (!$order) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Order not found'
                ], 404);
            }

            // Update order berdasarkan status dari Midtrans
            $this->updateOrderFromStatus($order, $statusData);

            return response()->json([
                'success' => true,
                'order' => [
                    'id' => $order->id,
                    'order_id' => $order->order_id,
                    'status' => $order->status,
                    'payment_status' => $order->payment_status,
                    'payment_method' => $order->payment_method
                ],
                'payment_status' => $statusData
            ]);

        } catch (\Exception $e) {
            Log::error('❌ Error checking payment status: ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper method untuk update order dari status Midtrans
     */
    private function updateOrderFromStatus($order, $statusData)
    {
        $transactionStatus = $statusData['transaction_status'];
        $updateData = [
            'midtrans_transaction_id' => $statusData['transaction_id'] ?? $order->midtrans_transaction_id
        ];

        if (in_array($transactionStatus, ['capture', 'settlement'])) {
            $updateData['payment_status'] = 'paid';
            $updateData['status'] = 'confirmed';
            $updateData['paid_at'] = now();
        } elseif ($transactionStatus == 'pending') {
            $updateData['payment_status'] = 'pending';
            $updateData['status'] = 'pending';
        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            $updateData['payment_status'] = 'failed';
            $updateData['status'] = 'cancelled';
        }

        $order->update($updateData);
        Log::info('✅ Order updated from status check', [
            'order_id' => $order->order_id,
            'transaction_status' => $transactionStatus,
            'new_status' => $order->status
        ]);
    }

    public function paymentSuccess(Request $request)
    {
        $orderId = $request->query('order_id');
        Log::info('✅ Payment success callback', ['order_id' => $orderId]);
        
        return response()->json([
            'success' => true,
            'message' => 'Payment successful',
            'order_id' => $orderId
        ]);
    }

    public function paymentFailed(Request $request)
    {
        $orderId = $request->query('order_id');
        Log::info('❌ Payment failed callback', ['order_id' => $orderId]);
        
        return response()->json([
            'success' => false,
            'message' => 'Payment failed',
            'order_id' => $orderId
        ]);
    }

    public function paymentPending(Request $request)
    {
        $orderId = $request->query('order_id');
        Log::info('⏳ Payment pending callback', ['order_id' => $orderId]);
        
        return response()->json([
            'success' => true,
            'message' => 'Payment pending',
            'order_id' => $orderId
        ]);
    }
}