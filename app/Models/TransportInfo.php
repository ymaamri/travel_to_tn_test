<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class TransportInfo extends Model
{
    protected $table = 'transport_infos';

    protected $fillable = [
        'slug',
        'title',
        'content',
        'featured_image',
        'gallery',
        'map_url',
        'contact_info',
        'is_published',
        'created_by',
    ];

    protected $casts = [
        'gallery' => 'array',
        'is_published' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transport) {
            if (empty($transport->slug)) {
                $transport->slug = Str::slug($transport->title);
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
}