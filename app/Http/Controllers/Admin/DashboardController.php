<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);

        // Double protection
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->isAdmin()) {
                abort(403, 'Unauthorized access.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        // Verifikasi tambahan
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
        ];

        // Monthly reservations di-cache terpisah
        $monthlyReservations = $this->getMonthlyReservations();

        return view('admin.dashboard', array_merge($stats, [
            'monthlyReservations' => $monthlyReservations,
        ]));
    }

    protected function getMonthlyReservations()
    {
        // FIX: Gunakan Carbon/Eloquent untuk database agnostic
        $monthly = [];
        
        for ($i = 1; $i <= 12; $i++) {
            $count = Reservation::whereYear('reservation_time', now()->year)
                ->whereMonth('reservation_time', $i)
                ->count();
            $monthly[$i] = $count;
        }

        return $monthly;
    }

    // Alternative method jika butuh lebih cepat
    protected function getMonthlyReservationsAlternative()
    {
        // Untuk database yang support strftime (SQLite)
        if (config('database.default') === 'sqlite') {
            $result = Reservation::selectRaw('strftime("%m", reservation_time) as month, COUNT(*) as count')
                ->whereRaw('strftime("%Y", reservation_time) = ?', [now()->year])
                ->groupBy('month')
                ->pluck('count', 'month');
        } else {
            // Untuk MySQL
            $result = Reservation::selectRaw('MONTH(reservation_time) as month, COUNT(*) as count')
                ->whereYear('reservation_time', now()->year)
                ->groupBy('month')
                ->pluck('count', 'month');
        }

        // Inisialisasi semua bulan agar tetap lengkap
        $monthly = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthly[$i] = $result[$i] ?? 0;
        }

        return $monthly;
    }
}