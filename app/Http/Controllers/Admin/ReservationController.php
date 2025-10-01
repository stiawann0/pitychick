<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['table', 'user'])->latest()->paginate(10);
        return view('admin.reservations.index', compact('reservations'));
    }

    public function create()
    {
        $tables = Table::available()->get();
        return view('admin.reservations.create', compact('tables'));
    }

    public function store(Request $request)
    {
        try {
            // Validasi manual - TANPA menu
            $validated = $request->validate([
                'customer_name' => 'required|string|max:255',
                'customer_email' => 'required|email',
                'customer_phone' => 'required|string|max:20',
                'reservation_date' => 'required|date|after_or_equal:today',
                'reservation_time' => 'required',
                'table_id' => 'required|exists:tables,id',
                'guest_count' => 'required|integer|min:1',
                'special_requests' => 'nullable|string',
            ]);

            DB::beginTransaction();

            // Ambil meja
            $table = Table::findOrFail($request->table_id);
            
            // Cek apakah meja available
            if ($table->status !== 'available') {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Meja tidak tersedia. Silakan pilih meja lain.');
            }

            // Buat reservasi - TANPA menu
            $reservation = Reservation::create([
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'reservation_date' => $validated['reservation_date'],
                'reservation_time' => $validated['reservation_time'],
                'table_id' => $validated['table_id'],
                'guest_count' => $validated['guest_count'],
                'special_requests' => $validated['special_requests'],
                'user_id' => auth()->id(),
                'status' => 'pending',
                'total_price' => 0, // Tetap 0 karena tanpa menu
                'payment_status' => 'unpaid',
            ]);

            // Update status meja
            $table->update(['status' => 'reserved']);

            DB::commit();

            return redirect()->route('admin.reservations.index')
                ->with('success', 'Reservasi berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Reservation creation failed: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal membuat reservasi: ' . $e->getMessage());
        }
    }

    public function show(Reservation $reservation)
    {
        return view('admin.reservations.show', compact('reservation'));
    }

    public function edit(Reservation $reservation)
    {
        $tables = Table::all();
        return view('admin.reservations.edit', compact('reservation', 'tables'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        try {
            // Validasi sederhana - TANPA menu
            $validated = $request->validate([
                'customer_name' => 'required|string|max:255',
                'customer_email' => 'required|email',
                'customer_phone' => 'required|string|max:20',
                'reservation_date' => 'required|date',
                'reservation_time' => 'required',
                'table_id' => 'required|exists:tables,id',
                'guest_count' => 'required|integer|min:1',
                'special_requests' => 'nullable|string',
            ]);

            DB::beginTransaction();

            $reservation->update($validated);

            DB::commit();

            return redirect()->route('admin.reservations.index')
                ->with('success', 'Reservasi berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Reservation update failed: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui reservasi: ' . $e->getMessage());
        }
    }

    public function destroy(Reservation $reservation)
    {
        try {
            DB::beginTransaction();

            // Kembalikan status meja
            $reservation->table->update(['status' => 'available']);
            
            $reservation->delete();

            DB::commit();

            return redirect()->route('admin.reservations.index')
                ->with('success', 'Reservasi berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Reservation deletion failed: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Gagal menghapus reservasi: ' . $e->getMessage());
        }
    }

    public function confirm(Reservation $reservation)
    {
        try {
            $reservation->update(['status' => 'confirmed']);
            return back()->with('success', 'Reservasi berhasil dikonfirmasi');
        } catch (\Exception $e) {
            Log::error('Reservation confirmation failed: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengonfirmasi reservasi');
        }
    }

    public function cancel(Reservation $reservation)
    {
        try {
            DB::beginTransaction();
            
            $reservation->update([
                'status' => 'cancelled',
                'cancelled_at' => now()
            ]);
            
            // Kembalikan status meja
            $reservation->table->update(['status' => 'available']);
            
            DB::commit();
            
            return back()->with('success', 'Reservasi berhasil dibatalkan');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Reservation cancellation failed: ' . $e->getMessage());
            return back()->with('error', 'Gagal membatalkan reservasi');
        }
    }
}