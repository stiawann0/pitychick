<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reservation extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'table_id',
        'reservation_date',
        'reservation_time',
        'guest_number',
        'notes',
        'is_walk_in',
        'status',
        'cancelled_at'
    ];

    protected $casts = [
        'reservation_date' => 'date',
        'reservation_time' => 'datetime',
        'is_walk_in' => 'boolean',
        'cancelled_at' => 'datetime'
    ];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', self::STATUS_CONFIRMED);
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', self::STATUS_CANCELLED);
    }

    // Accessors
    public function getFormattedReservationDateAttribute()
    {
        return $this->reservation_date?->format('d M Y') ?? 'N/A';
    }

    public function getFormattedReservationTimeAttribute()
    {
        return $this->reservation_time?->format('H:i') ?? 'N/A';
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'reservation_menu')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }

}