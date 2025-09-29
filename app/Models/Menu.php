<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'image'
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class, 'reservation_menu')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }

}