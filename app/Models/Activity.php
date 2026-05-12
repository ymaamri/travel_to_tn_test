<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

class Activity extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category',
        'price_range',
        'duration',
        'difficulty',
        'location',
        'photos',
        'description',
        'booking_info',
        'meta_title',
        'meta_description',
        'is_published',
        'created_by',
    ];

    protected $casts = [
        'photos' => 'array',
        'is_published' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($activity) {
            if (empty($activity->slug)) {
                $activity->slug = Str::slug($activity->title);
            }
        });

        static::updating(function ($activity) {
            if ($activity->isDirty('title') && empty($activity->slug)) {
                $activity->slug = Str::slug($activity->title);
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
     * Get all reviews for this activity (polymorphic).
     */
    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
}