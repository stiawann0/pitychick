<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\MidtransService;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin');
    }

    // Tampilkan daftar reservasi
    public function index()
    {
        $reservations = Reservation::with(['table', 'user', 'menus'])->latest()->paginate(10);
        return view('admin.reservations.index', compact('reservations'));
    }

    // Form buat reservasi baru
    public function create()
    {
        $tables = Table::available()->get();
        $menus = Menu::orderBy('category')->get();
        return view('admin.reservations.create', compact('tables', 'menus'));
    }

    // Simpan reservasi baru
    public function store(StoreReservationRequest $request)
{
    try {
        DB::beginTransaction();

        // Ambil meja
        $table = Table::findOrFail($request->table_id);
        if (!$table->isAvailable()) {
            throw new \Exception('Meja tidak tersedia');
        }

        // Buat reservasi sementara dengan total_price 0
        $reservation = Reservation::create($request->validated() + [
            'user_id' => auth()->id(),
            'status' => Reservation::STATUS_PENDING,
            'total_price' => 0,
            'payment_status' => 'unpaid',
        ]);

        $totalPrice = 0;

        // Attach menu dan hitung total price
        if ($request->has('menus')) {
            $menusData = [];
            foreach ($request->menus as $menuId => $quantity) {
                $quantity = (int) $quantity;
                if ($quantity <= 0) continue;

                $menu = Menu::find($menuId);
                if (!$menu) continue;

                $menusData[$menuId] = [
                    'quantity' => $quantity,
                    'price' => $menu->price,
                ];

                $totalPrice += $menu->price * $quantity;
            }

            if ($totalPrice <= 0) {
                throw new \Exception('Total harga pemesanan tidak valid. Harap pilih menu terlebih dahulu.');
            }

            $reservation->menus()->attach($menusData);
        }

        // Update total_price di reservasi
        $reservation->update(['total_price' => $totalPrice]);

        // Tandai meja sebagai reserved
        $table->update(['status' => Table::STATUS_RESERVED]);

        // Generate Midtrans snap token (kirim object Reservation langsung)
        $midtransService = new \App\Services\MidtransService();
        $snapToken = $midtransService->createTransaction($reservation);

        $reservation->update(['snap_token' => $snapToken]);

        DB::commit();

        return redirect()->route('admin.reservations.index')
            ->with('success', 'Reservasi berhasil dibuat. Silakan lakukan pembayaran.');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Reservation creation failed: ' . $e->getMessage());

        return redirect()->back()
            ->withInput()
            ->with('error', 'Gagal membuat reservasi: ' . $e->getMessage());
    }
}

    // Form edit reservasi
    public function edit(Reservation $reservation)
    {
        $tables = Table::all();
        $menus = Menu::orderBy('category')->get();
        return view('admin.reservations.edit', compact('reservation', 'tables', 'menus'));
    }

    // Update reservasi
    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        try {
            DB::beginTransaction();

            $reservation->update($request->validated());

            DB::commit();

            return redirect()->route('admin.reservations.index')
                ->with('success', 'Reservasi berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Reservation update failed: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui reservasi');
        }
    }

    // Hapus reservasi
    public function destroy(Reservation $reservation)
    {
        try {
            DB::beginTransaction();

            $reservation->delete();
            $reservation->table->update(['status' => Table::STATUS_AVAILABLE]);

            DB::commit();

            return redirect()->route('admin.reservations.index')
                ->with('success', 'Reservasi berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Reservation deletion failed: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Gagal menghapus reservasi');
        }
    }

    // Konfirmasi reservasi
    public function confirm(Reservation $reservation)
    {
        return $this->updateStatus($reservation, Reservation::STATUS_CONFIRMED, 'Reservasi dikonfirmasi');
    }

    // Batalkan reservasi
    public function cancel(Reservation $reservation)
    {
        return $this->updateStatus($reservation, Reservation::STATUS_CANCELLED, 'Reservasi dibatalkan');
    }

    // Update status helper
    protected function updateStatus(Reservation $reservation, string $status, string $message)
    {
        try {
            DB::beginTransaction();

            $reservation->update(['status' => $status]);

            if ($status === Reservation::STATUS_CANCELLED) {
                $reservation->table->update(['status' => Table::STATUS_AVAILABLE]);
                $reservation->update(['cancelled_at' => now()]);
            }

            DB::commit();

            return back()->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Status update failed: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengubah status reservasi');
        }
    }
}
