<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

class Establishment extends Model
{
    protected $table = 'establishments';

    protected $fillable = [
        'name',
        'slug',
        'category',
        'description',
        'address',
        'city',
        'region',
        'latitude',
        'longitude',
        'price_range',
        'rating',
        'review_count',
        'amenities',
        'contact_phone',
        'contact_email',
        'website',
        'photos',
        'map_url',
        'is_published',
        'created_by',
    ];

    protected $casts = [
        'amenities' => 'array',
        'photos' => 'array',
        'is_published' => 'boolean',
        'rating' => 'decimal:1',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($establishment) {
            if (empty($establishment->slug)) {
                $establishment->slug = Str::slug($establishment->name);
            }
        });

        static::updating(function ($establishment) {
            if ($establishment->isDirty('name') && empty($establishment->slug)) {
                $establishment->slug = Str::slug($establishment->name);
            }
        });
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    // Helper: get category label for display
    public function getCategoryLabelAttribute(): string
    {
        $labels = [
            'hotel' => 'Hotel',
            'resort' => 'Resort',
            'hostel' => 'Hostel',
            'guest_house' => 'Guest House',
            'cafe' => 'Café',
            'traditional_restaurant' => 'Traditional Restaurant',
            'luxury_dining' => 'Luxury Dining',
        ];
        return $labels[$this->category] ?? ucfirst($this->category);
    }

    /**
     * Get all reviews for this establishment (polymorphic).
     */
    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
}