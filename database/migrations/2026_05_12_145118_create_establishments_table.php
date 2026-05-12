<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('establishments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('category', [
                'hotel',
                'resort',
                'hostel',
                'guest_house',
                'cafe',
                'traditional_restaurant',
                'luxury_dining'
            ])->default('hotel');
            $table->text('description')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('region')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('price_range')->nullable(); // e.g. "$$ (50-100 TND)"
            $table->decimal('rating', 2, 1)->default(0); // average rating 0-5
            $table->unsignedInteger('review_count')->default(0);
            $table->json('amenities')->nullable(); // store as JSON array, e.g. ["wifi", "parking"]
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('website')->nullable();
            $table->json('photos')->nullable(); // array of image paths
            $table->string('map_url')->nullable(); // Google Maps embed link
            $table->boolean('is_published')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('establishments');
    }
};