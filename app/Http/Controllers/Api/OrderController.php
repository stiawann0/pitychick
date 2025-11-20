<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Create new order
     */
    public function store(Request $request)
    {
        try {
            Log::info('Order Creation Request:', $request->all());

            // Validasi yang lebih komprehensif
            $validator = Validator::make($request->all(), [
                'order_id' => 'required|string|unique:orders,order_id',
                'profile_id' => 'nullable|exists:user_profiles,id',
                'customer.name' => 'required_without:profile_id|string|max:255',
                'customer.email' => 'required_without:profile_id|email',
                'customer.phone' => 'required_without:profile_id|string',
                'customer.address' => 'required_without:profile_id|string',
                'items' => 'required|array|min:1',
                'items.*.id' => 'required',
                'items.*.name' => 'required|string',
                'items.*.price' => 'required|numeric',
                'items.*.quantity' => 'required|integer|min:1',
                'items.*.size' => 'nullable|string',
                'items.*.spiceLevel' => 'nullable|string',
                'payment_method' => 'required|string|in:COD,Transfer,QRIS,midtrans',
                'shipping.fee' => 'required|numeric',
                'shipping.estimate' => 'required|string',
                'shipping.service' => 'nullable|string',
                'totals.subtotal' => 'required|numeric',
                'totals.shipping' => 'required|numeric',
                'totals.grand_total' => 'required|numeric',
                'notes' => 'nullable|string',
                // 🔥 PERBAIKAN: Terima status dari frontend
                'status' => 'sometimes|string',
                'payment_status' => 'sometimes|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $customerData = $this->getCustomerData($request);

            // 🔥 PERBAIKAN PENTING: Gunakan status dari request atau default PENDING
            $isCOD = $request->payment_method === 'COD';
            
            // 🔥 PERBAIKAN: SEMUA order mulai dengan status PENDING
            $paymentStatus = $request->payment_status ?? 'pending'; // 🔥 Default pending
            $orderStatus = $request->status ?? 'pending'; // 🔥 Default pending
            
            // 🔥 PERBAIKAN: Untuk COD, paid_at harus NULL sampai admin konfirmasi
            $paidAt = null;
            $paymentExpiredAt = !$isCOD ? now()->addHours(24) : null;

            // Data untuk disimpan - SESUAI STRUCTURE DATABASE
            $orderData = [
                'order_id' => $request->order_id, // Gunakan order_id dari frontend
                'user_id' => Auth::id(),
                
                // Customer data sebagai JSON
                'customer' => $customerData,
                
                // Items data sebagai JSON
                'items' => $request->items,
                
                // Payment data sebagai JSON
                'payment' => [
                    'method' => $request->payment_method,
                    'status' => $paymentStatus,
                    'amount' => $request->totals['grand_total']
                ],
                
                // Shipping data sebagai JSON
                'shipping' => $request->shipping,
                
                // Totals data sebagai JSON
                'totals' => $request->totals,
                
                // 🔥 PERBAIKAN: Status fields - GUNAKAN STATUS DARI REQUEST
                'payment_status' => $paymentStatus,
                'payment_method' => $request->payment_method,
                'status' => $orderStatus,
                
                // 🔥 PERBAIKAN: Payment tracking - COD: paid_at null
                'payment_expired_at' => $paymentExpiredAt,
                'paid_at' => $paidAt, // 🔥 SELALU null untuk order baru
                
                // Additional fields
                'estimated_delivery_time' => $request->shipping['estimate'] ?? '20-30 menit'
            ];

            Log::info('Prepared Order Data:', $orderData);

            // Simpan order ke database
            $order = Order::create($orderData);

            Log::info('Order Created Successfully:', [
                'order_id' => $order->order_id,
                'order_db_id' => $order->id,
                'status' => $order->status, // 🔥 Log status sebenarnya
                'payment_status' => $order->payment_status // 🔥 Log payment status sebenarnya
            ]);

            return response()->json([
                'success' => true,
                'order_id' => $order->order_id,
                'order_data' => $order,
                'payment_status' => $order->payment_status, // 🔥 Kembalikan status sebenarnya
                'order_status' => $order->status, // 🔥 Kembalikan status sebenarnya
                'is_cod' => $isCOD,
                'payment_expired_at' => $order->payment_expired_at,
                'message' => $isCOD ? 
                    '✅ Pesanan COD berhasil dibuat! Menunggu konfirmasi admin.' : 
                    '✅ Pesanan berhasil dibuat. Silakan selesaikan pembayaran dalam 24 jam.'
            ]);

        } catch (\Exception $e) {
            Log::error('Order Creation Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat pesanan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get customer data from profile or request
     */
    private function getCustomerData(Request $request)
    {
        if ($request->profile_id) {
            $profile = UserProfile::where('user_id', Auth::id())
                                 ->where('id', $request->profile_id)
                                 ->firstOrFail();
            
            return [
                'name' => $profile->name,
                'email' => $profile->email,
                'address' => $profile->address,
                'phone' => $profile->phone,
                'notes' => $request->notes
            ];
        } else {
            return [
                'name' => $request->customer['name'],
                'email' => $request->customer['email'],
                'address' => $request->customer['address'],
                'phone' => $request->customer['phone'],
                'notes' => $request->notes
            ];
        }
    }

    /**
     * Get user orders
     */
    public function index()
    {
        try {
            $orders = Order::where('user_id', Auth::id())
                          ->orderBy('created_at', 'desc')
                          ->get();

            return response()->json([
                'success' => true,
                'orders' => $orders,
                'summary' => [
                    'total' => $orders->count(),
                    'pending_payment' => $orders->where('payment_status', 'pending')->where('payment_expired_at', '>', now())->count(),
                    'paid' => $orders->where('payment_status', 'paid')->count(),
                    'expired' => $orders->where('payment_status', 'pending')->where('payment_expired_at', '<', now())->count(),
                    'cancelled' => $orders->where('status', 'cancelled')->count(),
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching orders: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data pesanan'
            ], 500);
        }
    }

    /**
     * Get specific order details
     */
    public function show($orderId)
    {
        try {
            $order = Order::where('order_id', $orderId)
                         ->where('user_id', Auth::id())
                         ->firstOrFail();

            return response()->json([
                'success' => true,
                'order' => $order,
                'status_info' => [
                    'payment_status' => $order->payment_status,
                    'payment_status_text' => $order->payment_status_text,
                    'order_status' => $order->status,
                    'order_status_text' => $order->order_status_text,
                    'is_paid' => $order->is_paid,
                    'is_pending_payment' => $order->is_pending_payment,
                    'is_expired' => $order->is_expired,
                    'is_cancelled' => $order->is_cancelled,
                    'can_be_cancelled' => $order->canBeCancelled(),
                    'payment_expired_at' => $order->payment_expired_at,
                    'paid_at' => $order->paid_at,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Order not found: ' . $e->getMessage(), ['order_id' => $orderId]);
            
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Check order status
     */
    public function checkStatus($orderId)
    {
        try {
            Log::info('Checking order status:', ['order_id' => $orderId]);

            $order = Order::where('order_id', $orderId)
                         ->where('user_id', Auth::id())
                         ->first();

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order dengan ID "' . $orderId . '" tidak ditemukan di sistem.'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'order_id' => $order->order_id,
                'status' => $order->status,
                'payment_status' => $order->payment_status,
                'payment_method' => $order->payment_method,
                'total_amount' => $order->totals['grand_total'] ?? 0,
                'created_at' => $order->created_at,
                'paid_at' => $order->paid_at,
                'payment_expired_at' => $order->payment_expired_at,
                'is_paid' => $order->payment_status === 'paid',
                'is_pending' => $order->payment_status === 'pending',
                'is_expired' => $order->payment_expired_at && $order->payment_expired_at < now(),
                'can_be_cancelled' => $order->canBeCancelled(),
                'status_text' => $this->getStatusText($order),
                'time_remaining' => $order->getPaymentTimeRemaining()
            ]);

        } catch (\Exception $e) {
            Log::error('Error checking order status: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal memeriksa status order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cancel order
     */
    public function cancel($orderId)
    {
        try {
            $order = Order::where('order_id', $orderId)
                         ->where('user_id', Auth::id())
                         ->firstOrFail();

            if (!$order->canBeCancelled()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan tidak bisa dibatalkan. Status: ' . $order->status
                ], 400);
            }

            $order->cancelOrder('Dibatalkan oleh customer');

            Log::info('Order cancelled:', ['order_id' => $orderId, 'user_id' => Auth::id()]);

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibatalkan',
                'order' => $order
            ]);

        } catch (\Exception $e) {
            Log::error('Error cancelling order: ' . $e->getMessage(), ['order_id' => $orderId]);
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal membatalkan pesanan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update order status (for admin/merchant)
     */
    public function updateStatus(Request $request, $orderId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'status' => 'required|in:pending,confirmed,processed,delivered,completed,cancelled',
                'notes' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $order = Order::where('order_id', $orderId)->firstOrFail();
            $order->updateStatus($request->status, $request->notes);

            Log::info('Order status updated:', [
                'order_id' => $orderId,
                'new_status' => $request->status,
                'updated_by' => Auth::id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status pesanan berhasil diperbarui',
                'order' => $order
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating order status: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status pesanan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mark order as paid (for payment callbacks)
     */
    public function markAsPaid(Request $request, $orderId)
    {
        try {
            $order = Order::where('order_id', $orderId)->firstOrFail();
            
            $validator = Validator::make($request->all(), [
                'payment_method' => 'nullable|string',
                'transaction_id' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $order->markAsPaid($request->payment_method);

            // Update payment data dengan transaction ID jika ada
            if ($request->transaction_id) {
                $paymentData = $order->payment ?? [];
                $paymentData['transaction_id'] = $request->transaction_id;
                $order->update(['payment' => $paymentData]);
            }

            Log::info('Order marked as paid:', [
                'order_id' => $orderId,
                'payment_method' => $request->payment_method,
                'transaction_id' => $request->transaction_id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil dikonfirmasi',
                'order' => $order
            ]);

        } catch (\Exception $e) {
            Log::error('Error marking order as paid: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengonfirmasi pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get status text for frontend
     */
    private function getStatusText($order)
    {
        if ($order->payment_status === 'paid') {
            return 'Pembayaran berhasil';
        } elseif ($order->payment_status === 'pending') {
            if ($order->payment_expired_at && $order->payment_expired_at < now()) {
                return 'Pembayaran kedaluwarsa';
            }
            return 'Menunggu pembayaran';
        } elseif ($order->status === 'cancelled') {
            return 'Pesanan dibatalkan';
        } elseif ($order->status === 'confirmed') {
            return 'Pesanan dikonfirmasi';
        } elseif ($order->status === 'processed') {
            return 'Sedang diproses';
        } elseif ($order->status === 'delivered') {
            return 'Sedang dikirim';
        } elseif ($order->status === 'completed') {
            return 'Pesanan selesai';
        }
        
        return 'Sedang diproses';
    }

    /**
     * Get order statistics for dashboard
     */
    public function getStatistics()
    {
        try {
            $userId = Auth::id();
            
            $totalOrders = Order::where('user_id', $userId)->count();
            $pendingOrders = Order::where('user_id', $userId)
                                ->where('payment_status', 'pending')
                                ->where('payment_expired_at', '>', now())
                                ->count();
            $completedOrders = Order::where('user_id', $userId)
                                  ->where('status', 'completed')
                                  ->count();
            $totalSpent = Order::where('user_id', $userId)
                             ->where('payment_status', 'paid')
                             ->sum('totals->grand_total');

            return response()->json([
                'success' => true,
                'statistics' => [
                    'total_orders' => $totalOrders,
                    'pending_orders' => $pendingOrders,
                    'completed_orders' => $completedOrders,
                    'total_spent' => $totalSpent,
                    'average_order_value' => $totalOrders > 0 ? $totalSpent / $totalOrders : 0
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting order statistics: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil statistik pesanan'
            ], 500);
        }
    }
}