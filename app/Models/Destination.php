<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

class Destination extends Model
{
    protected $table = 'destinations';

    protected $fillable = [
        'name',
        'slug',
        'type',
        'overview',
        'history',
        'things_to_do',
        'best_restaurants',
        'hotels',
        'weather',
        'transportation',
        'best_season',
        'local_foods',
        'budget_estimate',
        'safety_info',
        'map_url',
        'photo_gallery',
        'faqs',
        'nearby_attractions',
        'latitude',
        'longitude',
        'meta_title',
        'meta_description',
        'is_published',
        'created_by',
    ];

    protected $casts = [
        'photo_gallery' => 'array',
        'faqs' => 'array',
        'is_published' => 'boolean',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($destination) {
            if (empty($destination->slug)) {
                $destination->slug = Str::slug($destination->name);
            }
        });

        static::updating(function ($destination) {
            if ($destination->isDirty('name') && empty($destination->slug)) {
                $destination->slug = Str::slug($destination->name);
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

    /**
     * Get all reviews for this destination (polymorphic).
     */
    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
}