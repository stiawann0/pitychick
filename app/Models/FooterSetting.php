<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    protected $fillable = [
        'brand_name',
        'brand_description',
        'email',
        'phone',
        'instagram',
        'address',
        'footer_note',
    ];
}
