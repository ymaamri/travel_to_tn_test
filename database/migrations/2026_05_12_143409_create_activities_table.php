<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('category', [
                'beaches',
                'desert_tours',
                'museums',
                'roman_ruins',
                'hiking',
                'diving',
                'nightlife',
                'shopping',
                'traditional_markets',
                'food_tours',
                'festivals'
            ])->default('beaches');
            $table->string('price_range')->nullable(); // e.g., "$$ (10-30 TND)"
            $table->string('duration')->nullable();    // e.g., "2-3 hours"
            $table->string('difficulty')->nullable();  // Easy, Moderate, Hard
            $table->string('location')->nullable();
            $table->json('photos')->nullable();        // array of image paths
            $table->longText('description')->nullable();
            $table->text('booking_info')->nullable();  // contact, website, phone
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->boolean('is_published')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};