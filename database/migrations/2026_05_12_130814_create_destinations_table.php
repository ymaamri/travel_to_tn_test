<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('type', [
                'city',
                'region',
                'beach',
                'historical_place',
                'island',
                'desert_area',
                'village'
            ])->default('city');
            $table->longText('overview')->nullable();
            $table->longText('history')->nullable();
            $table->longText('things_to_do')->nullable();       // can store HTML or plain text
            $table->longText('best_restaurants')->nullable();
            $table->longText('hotels')->nullable();
            $table->text('weather')->nullable();
            $table->text('transportation')->nullable();
            $table->string('best_season')->nullable();
            $table->text('local_foods')->nullable();
            $table->string('budget_estimate')->nullable();
            $table->text('safety_info')->nullable();
            $table->string('map_url')->nullable();              // Google Maps embed link
            $table->json('photo_gallery')->nullable();          // array of image paths
            $table->json('faqs')->nullable();                   // array of {question, answer}
            $table->text('nearby_attractions')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->boolean('is_published')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};