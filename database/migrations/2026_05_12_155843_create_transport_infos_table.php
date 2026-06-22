<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transport_infos', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();          // e.g., 'airports', 'taxis', 'louage'
            $table->string('title');                   // e.g., 'Airports in Tunisia'
            $table->longText('content')->nullable();   // Full HTML content (maps, text, images)
            $table->string('featured_image')->nullable(); // Main image for the category
            $table->json('gallery')->nullable();       // Multiple images
            $table->string('map_url')->nullable();     // Google Maps embed URL
            $table->string('contact_info')->nullable(); // Phone, email, website if any
            $table->boolean('is_published')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transport_infos');
    }
};