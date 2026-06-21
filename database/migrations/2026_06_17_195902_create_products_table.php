<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('category');
            $table->string('subtitle')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('badge')->nullable();
            $table->text('description');
            $table->string('image');
            $table->string('secondary_image')->nullable();
            $table->json('gallery');
            $table->json('finishes');
            $table->json('sizes');
            $table->json('trust');
            $table->json('accordions');
            $table->boolean('is_best_seller')->default(false);
            $table->boolean('in_collections')->default(false);
            $table->boolean('is_archive_featured')->default(false);
            $table->boolean('in_archive')->default(false);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
