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
        Schema::table('categories', function (Blueprint $table) {
            $table->string('slug', 60)->nullable()->after('id');
            $table->string('name_en', 100)->nullable()->after('slug');
            $table->string('name_ar', 100)->nullable()->after('name_en');
        });

        $arabicNames = [
            'Watches'       => 'ساعات',
            'T-Shirts'      => 'تيشيرتات',
            'Jewelry'       => 'مجوهرات',
            'Hoodies'       => 'هوديز',
            'LUXE AURA'     => 'LUXE AURA',
            'Outerwear'     => 'ملابس خارجية',
            'Apparel'       => 'ملابس',
            'Leather Goods' => 'منتجات جلدية',
            'Footwear'      => 'أحذية',
            'Knitwear'      => 'تريكو',
        ];

        foreach (DB::table('categories')->get() as $category) {
            DB::table('categories')->where('id', $category->id)->update([
                'slug'    => \Illuminate\Support\Str::slug($category->name) . '-' . $category->id,
                'name_en' => $category->name,
                'name_ar' => $arabicNames[$category->name] ?? $category->name,
            ]);
        }

        Schema::table('categories', function (Blueprint $table) {
            $table->unique('slug');
            $table->dropColumn('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('name')->nullable()->after('id');
        });

        foreach (DB::table('categories')->get() as $category) {
            DB::table('categories')->where('id', $category->id)->update([
                'name' => $category->name_en,
            ]);
        }

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['slug', 'name_en', 'name_ar']);
        });
    }
};
