<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewSettingsController extends Controller
{
    public function index()
    {
        $reviews = Review::all()->map(function ($review) {
            return [
                'img' => asset('storage/review/' . basename($review->img)),
                'name' => $review->name,
                'description' => $review->description,
            ];
        });

        return response()->json($reviews);
    }
}
