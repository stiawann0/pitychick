<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'customer',
        'items',
        'payment',
        'payment_status',
        'payment_method',
        'paid_at',
        'payment_expired_at',
        'payment_notes',
        'shipping', 
        'totals',
        'status',
        'driver_info',
        'confirmed_at',
        'processed_at',
        'delivered_at',
        'completed_at',
        'estimated_delivery_time'
    ];

    protected $casts = [
        'customer' => 'array',
        'items' => 'array',
        'payment' => 'array',
        'shipping' => 'array',
        'totals' => 'array',
        'driver_info' => 'array',
        'paid_at' => 'datetime',
        'payment_expired_at' => 'datetime',
        'confirmed_at' => 'datetime',
        'processed_at' => 'datetime',
        'delivered_at' => 'datetime',
        'completed_at' => 'datetime'
    ];

    // 🔥 PERBAIKAN: Definisikan status yang valid
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_PROCESSED = 'processed'; // 🔥 UBAH: processing -> processed
    const STATUS_DELIVERED = 'delivered';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    const PAYMENT_STATUS_PENDING = 'pending';
    const PAYMENT_STATUS_PAID = 'paid';
    const PAYMENT_STATUS_FAILED = 'failed';
    const PAYMENT_STATUS_EXPIRED = 'expired';
    const PAYMENT_STATUS_REFUNDED = 'refunded';

    protected $appends = [
        'is_paid',
        'is_pending_payment',
        'is_expired',
        'is_cancelled',
        'is_confirmed',
        'payment_status_text',
        'order_status_text',
        'grand_total',
        'is_delivered_unpaid_cod',
        'cod_paid_at'
    ];

    // ==================== SCOPES ====================

    public function scopePendingPayment($query)
    {
        return $query->where('payment_status', 'pending')
                    ->where(function($q) {
                        $q->whereNull('payment_expired_at')
                          ->orWhere('payment_expired_at', '>', now());
                    });
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    public function scopeFailedPayment($query)
    {
        return $query->where('payment_status', 'failed');
    }

    public function scopeExpiredPayment($query)
    {
        return $query->where('payment_status', 'pending')
                    ->where('payment_expired_at', '<', now());
    }

    // SCOPE untuk status
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', self::STATUS_CONFIRMED);
    }

    public function scopeProcessed($query)
    {
        return $query->where('status', self::STATUS_PROCESSED); // 🔥 PERBAIKAN
    }

    public function scopeDelivered($query)
    {
        return $query->where('status', self::STATUS_DELIVERED);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', self::STATUS_CANCELLED);
    }

    // 🔥 SCOPE BARU: COD yang sudah delivered tapi belum dibayar
    public function scopeDeliveredUnpaidCOD($query)
    {
        return $query->where('payment_method', 'COD')
                    ->where('status', self::STATUS_DELIVERED)
                    ->where('payment_status', 'pending');
    }

    // ==================== STATUS MANAGEMENT ====================

    /**
     * Update order status dengan validasi transisi dan timestamp otomatis
     */
    public function updateStatus($newStatus, $notes = null)
    {
        // 🔥 PERBAIKAN: Mapping status untuk kompatibilitas
        $statusMapping = [
            'processing' => self::STATUS_PROCESSED, // 🔥 Mapping: processing -> processed
            'process' => self::STATUS_PROCESSED     // 🔥 Mapping: process -> processed
        ];
        
        $modelStatus = $statusMapping[$newStatus] ?? $newStatus;

        // 🔥 PERBAIKAN: Valid transisi dengan status yang benar
        $validTransitions = [
            self::STATUS_PENDING => [self::STATUS_CONFIRMED, self::STATUS_CANCELLED],
            self::STATUS_CONFIRMED => [self::STATUS_PROCESSED, self::STATUS_CANCELLED], // 🔥 PERBAIKAN
            self::STATUS_PROCESSED => [self::STATUS_DELIVERED, self::STATUS_CANCELLED], // 🔥 PERBAIKAN
            self::STATUS_DELIVERED => [self::STATUS_COMPLETED, self::STATUS_CANCELLED],
            self::STATUS_COMPLETED => [],
            self::STATUS_CANCELLED => []
        ];

        if (!in_array($modelStatus, $validTransitions[$this->status] ?? [])) {
            throw new \Exception("Invalid status transition from {$this->status} to {$modelStatus}");
        }

        $updates = ['status' => $modelStatus];

        // Set timestamps berdasarkan status
        $timestampMap = [
            self::STATUS_CONFIRMED => 'confirmed_at',
            self::STATUS_PROCESSED => 'processed_at', // 🔥 PERBAIKAN
            self::STATUS_DELIVERED => 'delivered_at',
            self::STATUS_COMPLETED => 'completed_at'
        ];

        if (isset($timestampMap[$modelStatus])) {
            $updates[$timestampMap[$modelStatus]] = now();
        }

        // Untuk COD, jika completed maka payment juga paid
        if ($modelStatus === self::STATUS_COMPLETED && $this->payment_method === 'COD' && $this->payment_status === 'pending') {
            $updates['payment_status'] = self::PAYMENT_STATUS_PAID;
            $updates['paid_at'] = now();
            // Simpan cod_paid_at di payment array
            $paymentData = $this->payment ?? [];
            $paymentData['cod_paid_at'] = now()->toDateTimeString();
            $updates['payment'] = $paymentData;
        }

        // Jika cancelled, payment status juga failed
        if ($modelStatus === self::STATUS_CANCELLED && $this->payment_status === 'pending') {
            $updates['payment_status'] = self::PAYMENT_STATUS_FAILED;
        }

        // Tambahkan notes jika ada
        if ($notes) {
            $updates['payment_notes'] = $notes;
        }

        return $this->update($updates);
    }

    /**
     * Assign driver ke order
     */
    public function assignDriver($driverData)
    {
        $driverInfo = array_merge(
            $driverData, 
            ['assigned_at' => now()->toDateTimeString()]
        );
        
        return $this->update(['driver_info' => $driverInfo]);
    }

    // ==================== PAYMENT MANAGEMENT ====================

    public function markAsPaid($paymentMethod = null)
    {
        $updates = [
            'payment_status' => self::PAYMENT_STATUS_PAID,
            'paid_at' => now(),
            'status' => self::STATUS_CONFIRMED
        ];

        if ($paymentMethod) {
            $updates['payment_method'] = $paymentMethod;
        }

        return $this->update($updates);
    }

    // 🔥 METHOD BARU: Complete COD Payment (Uang Masuk)
    public function completeCodPayment()
    {
        if ($this->payment_method !== 'COD') {
            throw new \Exception("Hanya order COD yang bisa complete payment");
        }

        if ($this->status !== self::STATUS_DELIVERED) {
            throw new \Exception("Order harus dalam status delivered sebelum complete payment");
        }

        if ($this->payment_status === self::PAYMENT_STATUS_PAID) {
            throw new \Exception("Payment sudah completed sebelumnya");
        }

        // 🔥 UANG MASUK DI SINI - Simpan cod_paid_at di payment array
        $paymentData = $this->payment ?? [];
        $paymentData['cod_paid_at'] = now()->toDateTimeString();

        return $this->update([
            'payment_status' => self::PAYMENT_STATUS_PAID,
            'status' => self::STATUS_COMPLETED,
            'paid_at' => now(),
            'completed_at' => now(),
            'payment' => $paymentData
        ]);
    }

    public function markAsFailed($reason = null)
    {
        return $this->update([
            'payment_status' => self::PAYMENT_STATUS_FAILED,
            'payment_notes' => $reason
        ]);
    }

    public function markAsExpired()
    {
        return $this->update([
            'payment_status' => self::PAYMENT_STATUS_EXPIRED,
            'status' => self::STATUS_CANCELLED
        ]);
    }

    public function cancelOrder($reason = null)
    {
        $paymentStatus = $this->payment_status === self::PAYMENT_STATUS_PAID ? self::PAYMENT_STATUS_REFUNDED : self::PAYMENT_STATUS_FAILED;
        
        return $this->update([
            'status' => self::STATUS_CANCELLED,
            'payment_status' => $paymentStatus,
            'payment_notes' => $reason
        ]);
    }

    public function confirmOrder()
    {
        return $this->update([
            'status' => self::STATUS_CONFIRMED,
            'confirmed_at' => now()
        ]);
    }

    // ==================== ACCESSORS & MUTATORS ====================

    public function getIsPaidAttribute()
    {
        return $this->payment_status === self::PAYMENT_STATUS_PAID;
    }

    public function getIsPendingPaymentAttribute()
    {
        return $this->payment_status === self::PAYMENT_STATUS_PENDING && 
               (!$this->payment_expired_at || $this->payment_expired_at > now());
    }

    public function getIsExpiredAttribute()
    {
        return $this->payment_status === self::PAYMENT_STATUS_PENDING && 
               $this->payment_expired_at && 
               $this->payment_expired_at < now();
    }

    public function getIsCancelledAttribute()
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    public function getIsConfirmedAttribute()
    {
        return $this->status === self::STATUS_CONFIRMED;
    }

    // 🔥 ACCESSOR BARU: Cek apakah COD delivered tapi belum dibayar
    public function getIsDeliveredUnpaidCodAttribute()
    {
        return $this->payment_method === 'COD' && 
               $this->status === self::STATUS_DELIVERED && 
               $this->payment_status === self::PAYMENT_STATUS_PENDING;
    }

    // 🔥 ACCESSOR untuk cod_paid_at (ambil dari payment JSON)
    public function getCodPaidAtAttribute()
    {
        $paymentData = $this->payment ?? [];
        return isset($paymentData['cod_paid_at']) ? \Carbon\Carbon::parse($paymentData['cod_paid_at']) : null;
    }

    public function getPaymentStatusTextAttribute()
    {
        $statuses = [
            self::PAYMENT_STATUS_PENDING => 'Menunggu Pembayaran',
            self::PAYMENT_STATUS_PAID => 'Lunas',
            self::PAYMENT_STATUS_FAILED => 'Gagal',
            self::PAYMENT_STATUS_EXPIRED => 'Kadaluarsa',
            self::PAYMENT_STATUS_REFUNDED => 'Dikembalikan'
        ];

        return $statuses[$this->payment_status] ?? $this->payment_status;
    }

    public function getOrderStatusTextAttribute()
    {
        $statuses = [
            self::STATUS_PENDING => 'Menunggu Konfirmasi',
            self::STATUS_CONFIRMED => 'Dikonfirmasi',
            self::STATUS_PROCESSED => 'Sedang Diproses', // 🔥 PERBAIKAN
            self::STATUS_DELIVERED => 'Terkirim',
            self::STATUS_COMPLETED => 'Selesai',
            self::STATUS_CANCELLED => 'Dibatalkan'
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    // 🔥 ACCESSOR untuk tampilan status di view (mapping ke processed)
    public function getDisplayStatusAttribute()
    {
        return $this->status; // 🔥 Kembalikan status asli
    }

    public function getGrandTotalAttribute()
    {
        return $this->totals['grand_total'] ?? 0;
    }

    public function getCustomerNameAttribute()
    {
        return $this->customer['name'] ?? 'N/A';
    }

    public function getCustomerEmailAttribute()
    {
        return $this->customer['email'] ?? 'N/A';
    }

    public function getCustomerPhoneAttribute()
    {
        return $this->customer['phone'] ?? 'N/A';
    }

    // ==================== RELATIONSHIPS ====================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ==================== UTILITIES ====================

    public static function generateOrderId()
    {
        do {
            $orderId = 'ORD' . now()->format('YmdHis') . Str::upper(Str::random(4));
        } while (static::where('order_id', $orderId)->exists());

        return $orderId;
    }

    public function setPaymentExpiry($hours = 24)
    {
        return $this->update([
            'payment_expired_at' => now()->addHours($hours)
        ]);
    }

    public function canBeCancelled()
    {
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_CONFIRMED]) && 
               !in_array($this->payment_status, [self::PAYMENT_STATUS_PAID, self::PAYMENT_STATUS_EXPIRED, self::PAYMENT_STATUS_REFUNDED]);
    }

    public function canBeProcessed()
    {
        return $this->status === self::STATUS_CONFIRMED && $this->is_paid;
    }

    /**
     * Check jika order sudah melewati batas waktu pembayaran
     */
    public function isPaymentExpired()
    {
        return $this->payment_expired_at && $this->payment_expired_at->isPast();
    }

    /**
     * Get sisa waktu pembayaran dalam menit
     */
    public function getPaymentTimeRemaining()
    {
        if (!$this->payment_expired_at || $this->is_paid) {
            return 0;
        }

        return now()->diffInMinutes($this->payment_expired_at, false);
    }
}