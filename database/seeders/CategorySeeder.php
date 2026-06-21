<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            0 => [
                'slug' => 'watches-1',
                'name_en' => 'Watches',
                'name_ar' => 'ساعات',
                'image' => 'images/watches.jpg',
                'span' => 'md:col-span-3 md:row-span-1',
                'delay' => '0ms',
                'sort_order' => 1,
            ],
            1 => [
                'slug' => 't-shirts-2',
                'name_en' => 'T-Shirts',
                'name_ar' => 'تيشيرتات',
                'image' => 'images/tshirts.jpg',
                'span' => 'md:col-span-3 md:row-span-1',
                'delay' => '100ms',
                'sort_order' => 2,
            ],
            2 => [
                'slug' => 'jewelry-3',
                'name_en' => 'Jewelry',
                'name_ar' => 'مجوهرات',
                'image' => 'images/jewelry.jpg',
                'span' => 'md:col-span-2 md:row-span-1',
                'delay' => '200ms',
                'sort_order' => 3,
            ],
            3 => [
                'slug' => 'hoodies-4',
                'name_en' => 'Hoodies',
                'name_ar' => 'هوديز',
                'image' => 'images/hoodies.jpg',
                'span' => 'md:col-span-4 md:row-span-1',
                'delay' => '300ms',
                'sort_order' => 4,
            ],
            4 => [
                'slug' => 'outerwear-8',
                'name_en' => 'Outerwear',
                'name_ar' => 'ملابس خارجية',
                'image' => 'images/wool-coat.jpg',
                'span' => 'md:col-span-3 md:row-span-1',
                'delay' => '0ms',
                'sort_order' => 5,
            ],
            5 => [
                'slug' => 'luxe-aura-7',
                'name_en' => 'LUXE AURA',
                'name_ar' => 'LUXE AURA',
                'image' => 'categories/d4qgNQrIYHoYxBW5jNyMoFjfgcNJbUXoGWGI1Y1f.jpg',
                'span' => 'col-span-2',
                'delay' => '0ms',
                'sort_order' => 6,
            ],
            6 => [
                'slug' => 'apparel-9',
                'name_en' => 'Apparel',
                'name_ar' => 'ملابس',
                'image' => 'images/vest.jpg',
                'span' => 'md:col-span-3 md:row-span-1',
                'delay' => '100ms',
                'sort_order' => 6,
            ],
            7 => [
                'slug' => 'leather-goods-10',
                'name_en' => 'Leather Goods',
                'name_ar' => 'منتجات جلدية',
                'image' => 'images/pack.jpg',
                'span' => 'md:col-span-2 md:row-span-1',
                'delay' => '200ms',
                'sort_order' => 7,
            ],
            8 => [
                'slug' => 'footwear-11',
                'name_en' => 'Footwear',
                'name_ar' => 'أحذية',
                'image' => 'images/kicks.jpg',
                'span' => 'md:col-span-2 md:row-span-1',
                'delay' => '300ms',
                'sort_order' => 8,
            ],
            9 => [
                'slug' => 'knitwear-12',
                'name_en' => 'Knitwear',
                'name_ar' => 'تريكو',
                'image' => 'images/archive-cashmere.jpg',
                'span' => 'md:col-span-2 md:row-span-1',
                'delay' => '400ms',
                'sort_order' => 9,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
