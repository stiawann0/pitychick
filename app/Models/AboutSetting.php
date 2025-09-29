<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'description_1', 
        'description_2', 
        'main_image', 
        'story_image'
    ];

    public $timestamps = true;
}
