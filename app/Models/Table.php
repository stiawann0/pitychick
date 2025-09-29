<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Table extends Model
{
    use HasFactory;

    // Status constants
    const STATUS_AVAILABLE = 'available';
    const STATUS_RESERVED = 'reserved';
    const STATUS_OCCUPIED = 'occupied';
    const STATUS_MAINTENANCE = 'maintenance';

    public static $statuses = [
        self::STATUS_AVAILABLE => 'Available',
        self::STATUS_RESERVED => 'Reserved',
        self::STATUS_OCCUPIED => 'Occupied',
        self::STATUS_MAINTENANCE => 'Maintenance'
    ];

    protected $fillable = [
        'number',
        'capacity',
        'status',
        
    ];

    protected $casts = [
        'capacity' => 'integer'
    ];

    // Relationships
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('status', self::STATUS_AVAILABLE);
    }

    public function scopeReserved($query)
    {
        return $query->where('status', self::STATUS_RESERVED);
    }

    public function scopeOccupied($query)
    {
        return $query->where('status', self::STATUS_OCCUPIED);
    }

    // Helper methods
    public function isAvailable()
    {
        return $this->status === self::STATUS_AVAILABLE;
    }

    public function isReserved()
    {
        return $this->status === self::STATUS_RESERVED;
    }

    public function isOccupied()
    {
        return $this->status === self::STATUS_OCCUPIED;
    }

    public function isUnderMaintenance()
    {
        return $this->status === self::STATUS_MAINTENANCE;
    }
}