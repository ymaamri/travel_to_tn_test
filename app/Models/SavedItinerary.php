<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SavedItinerary extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'itinerary_data',
        'total_cost',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'itinerary_data' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}