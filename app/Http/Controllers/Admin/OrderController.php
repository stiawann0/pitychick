<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware('can:manage-orders');
    }

    public function index(Request $request)
    {
        $status = $request->get('status');
        $paymentStatus = $request->get('payment_status');
        $query = Order::with('user');

        // Filter by order status - PERBAIKI MAPPING STATUS
        if ($status) {
            $statusMap = [
                'processed' => 'processing' // 🔥 Mapping dari view ke model
            ];
            
            $modelStatus = $statusMap[$status] ?? $status;
            
            if (in_array($modelStatus, ['pending', 'confirmed', 'processing', 'delivered', 'completed', 'cancelled'])) {
                $query->where('status', $modelStatus);
            }
        }

        // Filter by payment status
        if ($paymentStatus && in_array($paymentStatus, ['paid', 'pending', 'failed', 'expired', 'cancelled'])) {
            $query->where('payment_status', $paymentStatus);
        }

        // 🔥 FILTER BARU: COD yang sudah delivered tapi belum dibayar
        if ($request->get('delivered_unpaid_cod')) {
            $query->where('payment_method', 'COD')
                  ->where('status', 'delivered')
                  ->where('payment_status', 'pending');
        }

        $orders = $query->latest()->paginate(10);

        // Statistics for dashboard - PERBAIKI MAPPING
        $stats = [
            'total' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'confirmed' => Order::where('status', 'confirmed')->count(),
            'processed' => Order::where('status', 'processing')->count(), // 🔥 PERBAIKAN
            'delivered' => Order::where('status', 'delivered')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
            // 🔥 STATS BARU: COD yang sudah delivered tapi belum dibayar
            'delivered_unpaid_cod' => Order::where('payment_method', 'COD')
                                         ->where('status', 'delivered')
                                         ->where('payment_status', 'pending')
                                         ->count(),
        ];

        return view('admin.orders.index', compact('orders', 'status', 'paymentStatus', 'stats'));
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,processed,delivered,completed,cancelled' // 🔥 PERBAIKAN: processed bukan processing
        ]);

        try {
            // Mapping status dari view ke model
            $statusMap = [
                'processed' => 'processing' // 🔥 PERBAIKAN
            ];
            
            $modelStatus = $statusMap[$request->status] ?? $request->status;
            $order->updateStatus($modelStatus);

            return redirect()->route('admin.orders.index')
                            ->with('success', 'Status pesanan berhasil diupdate');

        } catch (\Exception $e) {
            return redirect()->back()
                            ->with('error', 'Gagal update status: ' . $e->getMessage());
        }
    }

    // Quick Actions - PERBAIKI UNTUK ACTION DARI VIEW
    public function confirm(Order $order)
    {
        try {
            $order->updateStatus('confirmed');

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dikonfirmasi',
                'order' => [
                    'id' => $order->id,
                    'status' => $order->status,
                    'display_status' => $order->display_status, // 🔥 GUNAKAN DISPLAY STATUS
                    'status_text' => $order->order_status_text
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function process(Order $order)
    {
        try {
            $order->updateStatus('processing'); // 🔥 Tetap 'processing' di model

            return response()->json([
                'success' => true,
                'message' => 'Pesanan sedang diproses',
                'order' => [
                    'id' => $order->id,
                    'status' => $order->status,
                    'display_status' => $order->display_status, // 🔥 GUNAKAN DISPLAY STATUS
                    'status_text' => $order->order_status_text
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function deliver(Order $order)
    {
        try {
            $order->updateStatus('delivered');

            return response()->json([
                'success' => true,
                'message' => 'Pesanan sedang dikirim',
                'order' => [
                    'id' => $order->id,
                    'status' => $order->status,
                    'display_status' => $order->display_status, // 🔥 GUNAKAN DISPLAY STATUS
                    'status_text' => $order->order_status_text
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function complete(Order $order)
    {
        try {
            $order->updateStatus('completed');

            return response()->json([
                'success' => true,
                'message' => 'Pesanan telah selesai',
                'order' => [
                    'id' => $order->id,
                    'status' => $order->status,
                    'display_status' => $order->display_status, // 🔥 GUNAKAN DISPLAY STATUS
                    'status_text' => $order->order_status_text
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    // 🔥 METHOD BARU: Complete COD Payment (Uang Masuk)
    public function completeCodPayment(Order $order)
    {
        try {
            // Validasi: Hanya untuk COD yang sudah delivered dan belum dibayar
            if ($order->payment_method !== 'COD') {
                return response()->json([
                    'success' => false,
                    'message' => 'Hanya order COD yang bisa complete payment'
                ], 400);
            }

            if ($order->status !== 'delivered') {
                return response()->json([
                    'success' => false,
                    'message' => 'Order harus dalam status delivered sebelum complete payment'
                ], 400);
            }

            if ($order->payment_status === 'paid') {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment sudah completed sebelumnya'
                ], 400);
            }

            // 🔥 UANG MASUK DI SINI
            $order->completeCodPayment();

            Log::info('💰 COD Payment Completed - Uang Masuk', [
                'order_id' => $order->order_id,
                'amount' => $order->totals['grand_total'] ?? 0,
                'payment_status' => $order->payment_status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran COD berhasil diselesaikan - Uang telah masuk',
                'order' => [
                    'id' => $order->id,
                    'status' => $order->status,
                    'display_status' => $order->display_status, // 🔥 GUNAKAN DISPLAY STATUS
                    'payment_status' => $order->payment_status,
                    'status_text' => $order->order_status_text,
                    'payment_status_text' => $order->payment_status_text
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('❌ Error completing COD payment: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyelesaikan pembayaran COD: ' . $e->getMessage()
            ], 500);
        }
    }

    // Generic status update - PERBAIKI UNTUK ACTION DARI JAVASCRIPT
    public function updateStatus(Request $request, $orderId, $action)
    {
        try {
            $order = Order::findOrFail($orderId);
            
            // Mapping action dari JavaScript ke status model
            $actionMap = [
                'confirm' => 'confirmed',
                'process' => 'processing', // 🔥 PERBAIKAN: process -> processing
                'deliver' => 'delivered',
                'complete' => 'completed'
            ];

            if (!array_key_exists($action, $actionMap)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Aksi tidak valid'
                ], 400);
            }

            $status = $actionMap[$action];
            $order->updateStatus($status);

            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diupdate ke ' . $status,
                'order' => [
                    'id' => $order->id,
                    'status' => $order->status,
                    'display_status' => $order->display_status, // 🔥 GUNAKAN DISPLAY STATUS
                    'status_text' => $order->order_status_text
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating order status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    // Mark as paid manually
    public function markAsPaid(Request $request, Order $order)
    {
        try {
            $order->markAsPaid($request->payment_method);

            Log::info('Order marked as paid manually:', [
                'order_id' => $order->order_id,
                'payment_method' => $request->payment_method
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil dikonfirmasi',
                'order' => [
                    'id' => $order->id,
                    'payment_status' => $order->payment_status,
                    'payment_status_text' => $order->payment_status_text
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    // 🔥 METHOD BARU: Untuk menangani COD yang sudah delivered tapi belum dibayar
    public function getDeliveredUnpaidCOD()
    {
        try {
            $orders = Order::where('payment_method', 'COD')
                          ->where('status', 'delivered')
                          ->where('payment_status', 'pending')
                          ->latest()
                          ->paginate(10);

            $stats = [
                'total_unpaid_cod' => Order::where('payment_method', 'COD')
                                         ->where('status', 'delivered')
                                         ->where('payment_status', 'pending')
                                         ->count(),
                'total_amount_unpaid' => Order::where('payment_method', 'COD')
                                            ->where('status', 'delivered')
                                            ->where('payment_status', 'pending')
                                            ->get()
                                            ->sum(function($order) {
                                                return $order->totals['grand_total'] ?? 0;
                                            })
            ];

            return view('admin.orders.unpaid-cod', compact('orders', 'stats'));

        } catch (\Exception $e) {
            Log::error('Error getting delivered unpaid COD: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengambil data COD belum dibayar');
        }
    }
}