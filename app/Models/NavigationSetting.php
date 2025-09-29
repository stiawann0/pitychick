<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavigationSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'label', 
        'url', 
        'position', 
        'role', 
        'is_active',
    ];
}

