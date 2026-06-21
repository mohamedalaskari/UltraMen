<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('name_en')->nullable()->after('slug');
            $table->string('name_ar')->nullable()->after('name_en');
            $table->string('subtitle_en')->nullable()->after('category');
            $table->string('subtitle_ar')->nullable()->after('subtitle_en');
            $table->text('description_en')->nullable()->after('badge');
            $table->text('description_ar')->nullable()->after('description_en');
        });

        $categorySlugByName = DB::table('categories')->pluck('slug', 'name_en');

        foreach (DB::table('products')->get() as $product) {
            DB::table('products')->where('id', $product->id)->update([
                'name_en'        => $product->name,
                'name_ar'        => $product->name,
                'subtitle_en'    => $product->subtitle,
                'subtitle_ar'    => $product->subtitle,
                'description_en' => $product->description,
                'description_ar' => $product->description,
                'category'       => $categorySlugByName[$product->category] ?? $product->category,
            ]);
        }

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['name', 'subtitle', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('name')->nullable()->after('slug');
            $table->string('subtitle')->nullable()->after('category');
            $table->text('description')->nullable()->after('badge');
        });

        $categoryNameBySlug = DB::table('categories')->pluck('name_en', 'slug');

        foreach (DB::table('products')->get() as $product) {
            DB::table('products')->where('id', $product->id)->update([
                'name'        => $product->name_en,
                'subtitle'    => $product->subtitle_en,
                'description' => $product->description_en,
                'category'    => $categoryNameBySlug[$product->category] ?? $product->category,
            ]);
        }

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['name_en', 'name_ar', 'subtitle_en', 'subtitle_ar', 'description_en', 'description_ar']);
        });
    }
};
