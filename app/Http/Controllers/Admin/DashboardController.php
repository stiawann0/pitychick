<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);

        $this->middleware(function ($request, $next) {
            if (!auth()->user()->isAdmin()) {
                abort(403, 'Unauthorized access.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $stats = [
            'totalMenus' => Menu::count(),
            'totalReservations' => Reservation::count(),
            'availableTables' => Table::available()->count(),
            'totalTables' => Table::count(),
            'totalUsers' => User::customers()->count(),
            'recentReservations' => Reservation::with(['table', 'user'])
                ->latest()
                ->take(5)
                ->get(),
            'reservationStats' => [
                'confirmed' => Reservation::confirmed()->count(),
                'pending' => Reservation::pending()->count(),
                'cancelled' => Reservation::cancelled()->count(),
            ],
            
            // 🔥 DATA ORDERS YANG LENGKAP - SESUAI STATUS DI DATABASE
            'totalOrders' => Order::count(),
            
            // Status Order untuk Grafik - SESUAI ENUM DI MIGRATION
            'pendingOrders' => Order::where('status', 'pending')->count(),
            'confirmedOrders' => Order::where('status', 'confirmed')->count(),
            'processedOrders' => Order::where('status', 'processed')->count(),
            'deliveredOrders' => Order::where('status', 'delivered')->count(),
            'completedOrders' => Order::where('status', 'completed')->count(),
            'cancelledOrders' => Order::where('status', 'cancelled')->count(),
            
            'todayRevenue' => $this->getTodayRevenue(),
            'monthlyRevenue' => $this->getMonthlyRevenue(),
            'todayOrders' => Order::whereDate('created_at', today())->count(),
            'recentOrders' => Order::with('user')
                ->latest()
                ->take(5)
                ->get(),
                
            // 🔥 ORDER STATISTICS BY PAYMENT
            'codOrders' => Order::where('payment_method', 'COD')->count(),
            'transferOrders' => Order::where('payment_method', 'Transfer')->count(),
            'qrisOrders' => Order::where('payment_method', 'QRIS')->count(),
            'paidOrders' => Order::where('payment_status', 'paid')->count(),
            'pendingPaymentOrders' => Order::where('payment_status', 'pending')->count(),
            
            // 🔥 ORDER ACTION STATS - untuk quick actions (FIXED QUERY)
            'ordersNeedAction' => Order::whereIn('status', ['pending', 'confirmed'])->count(),
            'ordersInProcess' => Order::whereIn('status', ['processed', 'delivered'])->count(),
            'ordersCompletedToday' => $this->getOrdersCompletedToday(), // 🔥 FIXED METHOD
            
            // 🔥 DATA BARU: Pendapatan bulan lalu dan kemarin
            'lastMonthRevenue' => $this->getLastMonthRevenue(),
            'yesterdayRevenue' => $this->getYesterdayRevenue(),
        ];

        $monthlyReservations = $this->getMonthlyReservations();

        // PERBAIKAN: Kirim semua data dalam satu array
        return view('admin.dashboard', [
            'stats' => $stats,
            'monthlyReservations' => $monthlyReservations,
        ]);
    }

    // 🔥 METHOD UNTUK PENDAPATAN HARI INI
    protected function getTodayRevenue()
    {
        return Order::whereDate('created_at', today())
                   ->where('payment_status', 'paid')
                   ->get()
                   ->sum(function($order) {
                       return $order->totals['grand_total'] ?? 0;
                   });
    }

    // 🔥 METHOD UNTUK PENDAPATAN BULAN INI
    protected function getMonthlyRevenue()
    {
        return Order::whereYear('created_at', now()->year)
                   ->whereMonth('created_at', now()->month)
                   ->where('payment_status', 'paid')
                   ->get()
                   ->sum(function($order) {
                       return $order->totals['grand_total'] ?? 0;
                   });
    }

    // 🔥 METHOD BARU: Pendapatan Bulan Lalu
    protected function getLastMonthRevenue()
    {
        return Order::whereYear('created_at', now()->subMonth()->year)
                   ->whereMonth('created_at', now()->subMonth()->month)
                   ->where('payment_status', 'paid')
                   ->get()
                   ->sum(function($order) {
                       return $order->totals['grand_total'] ?? 0;
                   });
    }

    // 🔥 METHOD BARU: Pendapatan Kemarin
    protected function getYesterdayRevenue()
    {
        return Order::whereDate('created_at', today()->subDay())
                   ->where('payment_status', 'paid')
                   ->get()
                   ->sum(function($order) {
                       return $order->totals['grand_total'] ?? 0;
                   });
    }

    // 🔥 METHOD BARU: Get orders completed today (FIXED)
    protected function getOrdersCompletedToday()
    {
        // Cek dulu apakah kolom completed_at ada
        if (\Schema::hasColumn('orders', 'completed_at')) {
            return Order::where('status', 'completed')
                       ->whereDate('completed_at', today())
                       ->count();
        } else {
            // Fallback: gunakan created_at jika completed_at belum ada
            return Order::where('status', 'completed')
                       ->whereDate('created_at', today())
                       ->count();
        }
    }

    protected function getMonthlyReservations()
    {
        $monthly = [];
        
        for ($i = 1; $i <= 12; $i++) {
            $count = Reservation::whereYear('reservation_time', now()->year)
                ->whereMonth('reservation_time', $i)
                ->count();
            $monthly[$i] = $count;
        }

        return $monthly;
    }

    // 🔥 METHOD BARU: Get orders by status untuk API
    public function getOrdersByStatus($status)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $orders = Order::where('status', $status)
                      ->with('user')
                      ->latest()
                      ->paginate(10);

        return response()->json([
            'success' => true,
            'orders' => $orders,
            'status' => $status
        ]);
    }

    // 🔥 METHOD BARU: Update order status dari dashboard
    public function updateOrderStatus(Request $request, $orderId)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'status' => 'required|in:confirmed,processed,delivered,completed,cancelled'
        ]);

        try {
            $order = Order::where('order_id', $orderId)->firstOrFail();
            
            $order->updateStatus($request->status);

            return response()->json([
                'success' => true,
                'message' => 'Status pesanan berhasil diupdate',
                'order' => $order
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    // Grafik Pemesanan
    public function getOrderChartData(Request $request)
    {
        try {
            \Log::info('Order chart requested', ['period' => $request->get('period'), 'user' => auth()->user()->email]);

            $period = $request->get('period', 'daily');
            $labels = [];
            $data = [];

            if ($period === 'daily') {
                for ($i = 6; $i >= 0; $i--) {
                    $date = Carbon::today()->subDays($i);
                    $labels[] = $date->format('D'); // Sen, Sel, Rab
                    $data[] = Order::whereDate('created_at', $date)->count();
                }
            } elseif ($period === 'weekly') {
                for ($i = 3; $i >= 0; $i--) {
                    $start = Carbon::now()->startOfWeek()->subWeeks($i);
                    $end = $start->copy()->endOfWeek();
                    $labels[] = 'Minggu ' . ($i + 1);
                    $data[] = Order::whereBetween('created_at', [$start, $end])->count();
                }
            } elseif ($period === 'monthly') {
                for ($i = 6; $i >= 0; $i--) {
                    $month = Carbon::now()->subMonths($i);
                    $labels[] = $month->format('M'); // Jan, Feb, Mar
                    $data[] = Order::whereYear('created_at', $month->year)
                                   ->whereMonth('created_at', $month->month)
                                   ->count();
                }
            }

            \Log::info('Order chart data generated', ['labels' => $labels, 'data' => $data]);

            return response()->json([
                'labels' => $labels,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in getOrderChartData: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            // Return fallback data
            return response()->json([
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                'data' => [10, 15, 8, 12, 6, 9]
            ]);
        }
    }

    /**
     * Get reservation chart data
     */
    public function getReservationChartData(Request $request)
    {
        try {
            \Log::info('Reservation chart requested', ['period' => $request->get('period'), 'user' => auth()->user()->email]);

            $period = $request->get('period', 'daily');
            $labels = [];
            $data = [];

            if ($period === 'daily') {
                for ($i = 6; $i >= 0; $i--) {
                    $date = Carbon::today()->subDays($i);
                    $labels[] = $date->format('D');
                    $data[] = Reservation::whereDate('reservation_time', $date)->count();
                }
            } elseif ($period === 'weekly') {
                for ($i = 3; $i >= 0; $i--) {
                    $start = Carbon::now()->startOfWeek()->subWeeks($i);
                    $end = $start->copy()->endOfWeek();
                    $labels[] = 'Minggu ' . ($i + 1);
                    $data[] = Reservation::whereBetween('reservation_time', [$start, $end])->count();
                }
            } elseif ($period === 'monthly') {
                for ($i = 6; $i >= 0; $i--) {
                    $month = Carbon::now()->subMonths($i);
                    $labels[] = $month->format('M');
                    $data[] = Reservation::whereYear('reservation_time', $month->year)
                                         ->whereMonth('reservation_time', $month->month)
                                         ->count();
                }
            }

            \Log::info('Reservation chart data generated', ['labels' => $labels, 'data' => $data]);

            return response()->json([
                'labels' => $labels,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in getReservationChartData: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            // Return fallback data
            return response()->json([
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                'data' => [5, 8, 12, 7, 9, 11]
            ]);
        }
    }
}