<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            0 => [
                'slug' => 'chronos-vii-titanium',
                'name_en' => 'CHRONOS VII TITANIUM',
                'name_ar' => 'CHRONOS VII TITANIUM',
                'category' => 'watches-1',
                'subtitle_en' => 'LIMITED EDITION — 042/500',
                'subtitle_ar' => 'LIMITED EDITION — 042/500',
                'price' => 4850.0,
                'original_price' => null,
                'badge' => 'PRE-ORDER',
                'description_en' => 'A Modern Heirloom designed for the discerning individual. The CHRONOS VII is forged from aerospace-grade Grade 5 Titanium, housing our signature Calibre 9 movement. Every component is hand-finished in our laboratory, ensuring precision engineering that transcends generations.',
                'description_ar' => 'A Modern Heirloom designed for the discerning individual. The CHRONOS VII is forged from aerospace-grade Grade 5 Titanium, housing our signature Calibre 9 movement. Every component is hand-finished in our laboratory, ensuring precision engineering that transcends generations.',
                'image' => 'images/product-watch-main.jpg',
                'secondary_image' => 'images/product-watch-face.jpg',
                'gallery' => [
                    0 => [
                        'image' => 'images/product-watch-main.jpg',
                    ],
                    1 => [
                        'image' => 'images/product-watch-face.jpg',
                    ],
                    2 => [
                        'image' => 'images/product-watch-side.jpg',
                    ],
                    3 => [
                        'image' => 'images/product-watch-worn.jpg',
                    ],
                ],
                'finishes' => [
                    0 => [
                        'color' => '#BFC1C2',
                        'label' => 'Brushed Titanium',
                    ],
                    1 => [
                        'color' => '#131313',
                        'label' => 'Midnight Black',
                    ],
                    2 => [
                        'color' => '#C5A059',
                        'label' => 'Rose Gold',
                    ],
                ],
                'sizes' => [
                    0 => 'SMALL (18CM)',
                    1 => 'MEDIUM (20CM)',
                    2 => 'LARGE (22CM)',
                ],
                'trust' => [
                    0 => [
                        'icon' => 'local_shipping',
                        'label' => 'Free Shipping',
                    ],
                    1 => [
                        'icon' => 'verified_user',
                        'label' => 'Lifetime Warranty',
                    ],
                    2 => [
                        'icon' => 'lock',
                        'label' => 'Secure Checkout',
                    ],
                ],
                'accordions' => [
                    0 => [
                        'title' => 'MATERIALS',
                        'content' => 'Grade 5 Aerospace Titanium case and bracelet. Scratch-resistant double-domed sapphire crystal with 7-layer anti-reflective coating. Custom charcoal ceramic bezel insert.',
                    ],
                    1 => [
                        'title' => 'MOVEMENT',
                        'content' => 'In-house ULTRA Calibre 9 Automatic Movement. 72-hour power reserve. 28,800 vibrations per hour. 31 jewels. Meticulously hand-regulated to +/- 2 seconds per day.',
                    ],
                    2 => [
                        'title' => 'SHIPPING & RETURNS',
                        'content' => 'Complimentary global insured shipping on all watches. Standard 30-day return policy applies.',
                    ],
                ],
                'is_best_seller' => false,
                'in_collections' => false,
                'is_archive_featured' => false,
                'in_archive' => false,
                'labels' => [
                    0 => 'new_arrival',
                    1 => 'limited_edition',
                ],
                'sort_order' => 1,
            ],
            1 => [
                'slug' => 'titanium-ax-1',
                'name_en' => 'TITANIUM AX-1',
                'name_ar' => 'TITANIUM AX-1',
                'category' => 'watches-1',
                'subtitle_en' => 'CHRONOGRAPH SERIES',
                'subtitle_ar' => 'CHRONOGRAPH SERIES',
                'price' => 8450.0,
                'original_price' => null,
                'badge' => null,
                'description_en' => 'The pinnacle of watchmaking artistry. The TITANIUM AX-1 Chronograph features a micro-engraved titanium dial, our proprietary Calibre 12 Chronograph movement, and a sapphire exhibition caseback revealing 200 individual components in harmonious motion.',
                'description_ar' => 'The pinnacle of watchmaking artistry. The TITANIUM AX-1 Chronograph features a micro-engraved titanium dial, our proprietary Calibre 12 Chronograph movement, and a sapphire exhibition caseback revealing 200 individual components in harmonious motion.',
                'image' => 'images/watch-main.jpg',
                'secondary_image' => 'images/watch-detail.jpg',
                'gallery' => [
                    0 => [
                        'image' => 'images/watch-main.jpg',
                    ],
                    1 => [
                        'image' => 'images/watch-detail.jpg',
                    ],
                ],
                'finishes' => [
                    0 => [
                        'color' => '#BFC1C2',
                        'label' => 'Brushed Titanium',
                    ],
                    1 => [
                        'color' => '#131313',
                        'label' => 'Midnight Black',
                    ],
                ],
                'sizes' => [
                    0 => 'SMALL (18CM)',
                    1 => 'MEDIUM (20CM)',
                    2 => 'LARGE (22CM)',
                ],
                'trust' => [
                    0 => [
                        'icon' => 'local_shipping',
                        'label' => 'Free Shipping',
                    ],
                    1 => [
                        'icon' => 'verified_user',
                        'label' => 'Lifetime Warranty',
                    ],
                    2 => [
                        'icon' => 'lock',
                        'label' => 'Secure Checkout',
                    ],
                ],
                'accordions' => [
                    0 => [
                        'title' => 'MATERIALS',
                        'content' => 'Grade 5 Aerospace Titanium case. Anti-reflective sapphire crystal. Micro-engraved titanium dial.',
                    ],
                    1 => [
                        'title' => 'MOVEMENT',
                        'content' => 'ULTRA Calibre 12 Chronograph Movement. 60-hour power reserve. COSC certified chronometer precision.',
                    ],
                    2 => [
                        'title' => 'SHIPPING & RETURNS',
                        'content' => 'Complimentary global insured shipping. Standard 30-day return policy. Original condition required.',
                    ],
                ],
                'is_best_seller' => false,
                'in_collections' => true,
                'is_archive_featured' => false,
                'in_archive' => false,
                'labels' => [
                    0 => 'featured',
                ],
                'sort_order' => 2,
            ],
            2 => [
                'slug' => 'forged-monolith-ring',
                'name_en' => 'FORGED MONOLITH RING',
                'name_ar' => 'FORGED MONOLITH RING',
                'category' => 'jewelry-3',
                'subtitle_en' => 'FINE JEWELRY',
                'subtitle_ar' => 'FINE JEWELRY',
                'price' => 1200.0,
                'original_price' => null,
                'badge' => null,
                'description_en' => 'Sculpted from a single billet of aerospace-grade titanium using a cold-forging process exclusive to ULTRA. The Monolith Ring bears no joints or seams — a continuous loop of refined masculine energy.',
                'description_ar' => 'Sculpted from a single billet of aerospace-grade titanium using a cold-forging process exclusive to ULTRA. The Monolith Ring bears no joints or seams — a continuous loop of refined masculine energy.',
                'image' => 'images/monolith-ring.jpg',
                'secondary_image' => null,
                'gallery' => [
                    0 => [
                        'image' => 'images/monolith-ring.jpg',
                    ],
                    1 => [
                        'image' => 'images/jewelry.jpg',
                    ],
                ],
                'finishes' => [
                    0 => [
                        'color' => '#BFC1C2',
                        'label' => 'Raw Titanium',
                    ],
                    1 => [
                        'color' => '#131313',
                        'label' => 'Black PVD',
                    ],
                ],
                'sizes' => [
                    0 => 'SIZE 9',
                    1 => 'SIZE 10',
                    2 => 'SIZE 11',
                    3 => 'SIZE 12',
                ],
                'trust' => [
                    0 => [
                        'icon' => 'local_shipping',
                        'label' => 'Free Shipping',
                    ],
                    1 => [
                        'icon' => 'verified_user',
                        'label' => 'Lifetime Warranty',
                    ],
                    2 => [
                        'icon' => 'lock',
                        'label' => 'Secure Checkout',
                    ],
                ],
                'accordions' => [
                    0 => [
                        'title' => 'MATERIALS',
                        'content' => 'Cold-forged Grade 5 Titanium. Hypoallergenic and biocompatible. Brushed matte finish.',
                    ],
                    1 => [
                        'title' => 'SIZING',
                        'content' => 'Width: 12mm. Comfort-fit interior profile. Available in US ring sizes 9–12. Complimentary resizing within 30 days.',
                    ],
                    2 => [
                        'title' => 'SHIPPING & RETURNS',
                        'content' => 'Complimentary global insured shipping. 30-day return policy.',
                    ],
                ],
                'is_best_seller' => false,
                'in_collections' => true,
                'is_archive_featured' => false,
                'in_archive' => false,
                'labels' => [
                    0 => 'featured',
                    1 => 'new_arrival',
                ],
                'sort_order' => 3,
            ],
            3 => [
                'slug' => 'structured-wool-coat',
                'name_en' => 'STRUCTURED WOOL COAT',
                'name_ar' => 'STRUCTURED WOOL COAT',
                'category' => 'outerwear-8',
                'subtitle_en' => 'OUTERWEAR COLLECTION',
                'subtitle_ar' => 'OUTERWEAR COLLECTION',
                'price' => 2900.0,
                'original_price' => null,
                'badge' => null,
                'description_en' => 'Engineered in partnership with a historic Italian mill, this coat is woven from 100% virgin Merino wool at 800 grams per square metre. The structured shoulder and elongated silhouette define the ULTRA aesthetic.',
                'description_ar' => 'Engineered in partnership with a historic Italian mill, this coat is woven from 100% virgin Merino wool at 800 grams per square metre. The structured shoulder and elongated silhouette define the ULTRA aesthetic.',
                'image' => 'images/wool-coat.jpg',
                'secondary_image' => null,
                'gallery' => [
                    0 => [
                        'image' => 'images/wool-coat.jpg',
                    ],
                ],
                'finishes' => [
                    0 => [
                        'color' => '#444748',
                        'label' => 'Charcoal',
                    ],
                    1 => [
                        'color' => '#1b1c1c',
                        'label' => 'Midnight Black',
                    ],
                    2 => [
                        'color' => '#c4b99a',
                        'label' => 'Camel',
                    ],
                ],
                'sizes' => [
                    0 => 'XS',
                    1 => 'S',
                    2 => 'M',
                    3 => 'L',
                    4 => 'XL',
                ],
                'trust' => [
                    0 => [
                        'icon' => 'local_shipping',
                        'label' => 'Free Shipping',
                    ],
                    1 => [
                        'icon' => 'verified_user',
                        'label' => '2-Year Guarantee',
                    ],
                    2 => [
                        'icon' => 'lock',
                        'label' => 'Secure Checkout',
                    ],
                ],
                'accordions' => [
                    0 => [
                        'title' => 'MATERIALS',
                        'content' => '100% Virgin Merino Wool, 800gsm. Fully lined in Italian silk. Dry clean only.',
                    ],
                    1 => [
                        'title' => 'FIT',
                        'content' => 'Structured, relaxed silhouette. Length: 107cm. Fits true to size. Model is 6\'1\\" wearing size M.',
                    ],
                    2 => [
                        'title' => 'SHIPPING & RETURNS',
                        'content' => 'Complimentary global insured shipping. 30-day return policy.',
                    ],
                ],
                'is_best_seller' => false,
                'in_collections' => true,
                'is_archive_featured' => false,
                'in_archive' => false,
                'labels' => [
                    0 => 'featured',
                ],
                'sort_order' => 4,
            ],
            4 => [
                'slug' => 'ultra-stealth-vest',
                'name_en' => 'ULTRA STEALTH VEST',
                'name_ar' => 'ULTRA STEALTH VEST',
                'category' => 'apparel-9',
                'subtitle_en' => 'ESSENTIALS COLLECTION',
                'subtitle_ar' => 'ESSENTIALS COLLECTION',
                'price' => 450.0,
                'original_price' => null,
                'badge' => null,
                'description_en' => 'A technical foundation piece cut from our proprietary Ultra-Lite fabric — 92% Nylon, 8% Elastane, with a DWR coating for weather resistance. The fitted silhouette moves with the body.',
                'description_ar' => 'A technical foundation piece cut from our proprietary Ultra-Lite fabric — 92% Nylon, 8% Elastane, with a DWR coating for weather resistance. The fitted silhouette moves with the body.',
                'image' => 'images/vest.jpg',
                'secondary_image' => null,
                'gallery' => [
                    0 => [
                        'image' => 'images/vest.jpg',
                    ],
                ],
                'finishes' => [
                    0 => [
                        'color' => '#1b1c1c',
                        'label' => 'Stealth Black',
                    ],
                    1 => [
                        'color' => '#444748',
                        'label' => 'Charcoal',
                    ],
                ],
                'sizes' => [
                    0 => 'XS',
                    1 => 'S',
                    2 => 'M',
                    3 => 'L',
                    4 => 'XL',
                ],
                'trust' => [
                    0 => [
                        'icon' => 'local_shipping',
                        'label' => 'Free Shipping',
                    ],
                    1 => [
                        'icon' => 'verified_user',
                        'label' => '2-Year Guarantee',
                    ],
                    2 => [
                        'icon' => 'lock',
                        'label' => 'Secure Checkout',
                    ],
                ],
                'accordions' => [
                    0 => [
                        'title' => 'MATERIALS',
                        'content' => '92% Nylon, 8% Elastane. DWR coating. Machine washable at 30°C.',
                    ],
                    1 => [
                        'title' => 'FIT',
                        'content' => 'Slim-fit silhouette. Stretch panel at side seams. Model is 6\'1\\" wearing size M.',
                    ],
                    2 => [
                        'title' => 'SHIPPING & RETURNS',
                        'content' => 'Complimentary global insured shipping. 30-day return policy.',
                    ],
                ],
                'is_best_seller' => true,
                'in_collections' => false,
                'is_archive_featured' => false,
                'in_archive' => false,
                'labels' => [
                    0 => 'best_seller',
                ],
                'sort_order' => 5,
            ],
            5 => [
                'slug' => 'monolith-silver-ring',
                'name_en' => 'MONOLITH SILVER RING',
                'name_ar' => 'MONOLITH SILVER RING',
                'category' => 'jewelry-3',
                'subtitle_en' => 'FINE JEWELRY',
                'subtitle_ar' => 'FINE JEWELRY',
                'price' => 180.0,
                'original_price' => null,
                'badge' => null,
                'description_en' => 'Sterling silver, cold-forged and hand-polished. A minimal architectural statement for the modern collector. The beveled edge catches light with intentional precision.',
                'description_ar' => 'Sterling silver, cold-forged and hand-polished. A minimal architectural statement for the modern collector. The beveled edge catches light with intentional precision.',
                'image' => 'images/ring.jpg',
                'secondary_image' => null,
                'gallery' => [
                    0 => [
                        'image' => 'images/ring.jpg',
                    ],
                ],
                'finishes' => [
                    0 => [
                        'color' => '#e0e0e0',
                        'label' => 'Sterling Silver',
                    ],
                    1 => [
                        'color' => '#C5A059',
                        'label' => 'Gold Vermeil',
                    ],
                ],
                'sizes' => [
                    0 => 'SIZE 9',
                    1 => 'SIZE 10',
                    2 => 'SIZE 11',
                    3 => 'SIZE 12',
                ],
                'trust' => [
                    0 => [
                        'icon' => 'local_shipping',
                        'label' => 'Free Shipping',
                    ],
                    1 => [
                        'icon' => 'verified_user',
                        'label' => 'Lifetime Warranty',
                    ],
                    2 => [
                        'icon' => 'lock',
                        'label' => 'Secure Checkout',
                    ],
                ],
                'accordions' => [
                    0 => [
                        'title' => 'MATERIALS',
                        'content' => '925 Sterling Silver. Rhodium-plated for tarnish resistance. Hallmarked.',
                    ],
                    1 => [
                        'title' => 'SIZING',
                        'content' => 'Band width: 8mm. Available in US sizes 9–12.',
                    ],
                    2 => [
                        'title' => 'SHIPPING & RETURNS',
                        'content' => 'Complimentary global insured shipping. 30-day return policy.',
                    ],
                ],
                'is_best_seller' => true,
                'in_collections' => false,
                'is_archive_featured' => false,
                'in_archive' => false,
                'labels' => [
                    0 => 'best_seller',
                    1 => 'sale',
                ],
                'sort_order' => 6,
            ],
            6 => [
                'slug' => 'core-leather-pack',
                'name_en' => 'CORE LEATHER PACK',
                'name_ar' => 'CORE LEATHER PACK',
                'category' => 'leather-goods-10',
                'subtitle_en' => 'LEATHER GOODS',
                'subtitle_ar' => 'LEATHER GOODS',
                'price' => 890.0,
                'original_price' => null,
                'badge' => null,
                'description_en' => 'Constructed from full-grain vegetable-tanned leather, the Core Pack develops a deep patina unique to its owner. 20L capacity with a padded laptop sleeve for the 16" MacBook.',
                'description_ar' => 'Constructed from full-grain vegetable-tanned leather, the Core Pack develops a deep patina unique to its owner. 20L capacity with a padded laptop sleeve for the 16" MacBook.',
                'image' => 'images/pack.jpg',
                'secondary_image' => null,
                'gallery' => [
                    0 => [
                        'image' => 'images/pack.jpg',
                    ],
                ],
                'finishes' => [
                    0 => [
                        'color' => '#1b1c1c',
                        'label' => 'Midnight Black',
                    ],
                    1 => [
                        'color' => '#5D4A36',
                        'label' => 'Tobacco Brown',
                    ],
                ],
                'sizes' => [
                    0 => 'ONE SIZE',
                ],
                'trust' => [
                    0 => [
                        'icon' => 'local_shipping',
                        'label' => 'Free Shipping',
                    ],
                    1 => [
                        'icon' => 'verified_user',
                        'label' => '5-Year Guarantee',
                    ],
                    2 => [
                        'icon' => 'lock',
                        'label' => 'Secure Checkout',
                    ],
                ],
                'accordions' => [
                    0 => [
                        'title' => 'MATERIALS',
                        'content' => 'Full-grain vegetable-tanned cowhide leather. YKK zippers. Solid brass hardware.',
                    ],
                    1 => [
                        'title' => 'DIMENSIONS',
                        'content' => '20L capacity. 45cm × 30cm × 15cm. 16" laptop sleeve. External slip pocket.',
                    ],
                    2 => [
                        'title' => 'SHIPPING & RETURNS',
                        'content' => 'Complimentary global insured shipping. 30-day return policy.',
                    ],
                ],
                'is_best_seller' => true,
                'in_collections' => false,
                'is_archive_featured' => false,
                'in_archive' => false,
                'labels' => [
                    0 => 'best_seller',
                ],
                'sort_order' => 7,
            ],
            7 => [
                'slug' => 'nexus-performance-kicks',
                'name_en' => 'NEXUS PERFORMANCE KICKS',
                'name_ar' => 'NEXUS PERFORMANCE KICKS',
                'category' => 'footwear-11',
                'subtitle_en' => 'FOOTWEAR COLLECTION',
                'subtitle_ar' => 'FOOTWEAR COLLECTION',
                'price' => 220.0,
                'original_price' => null,
                'badge' => null,
                'description_en' => 'A technical running silhouette reimagined for urban luxury. Ultra-lightweight mesh upper, carbon-fiber heel counter, and our proprietary UltraFoam midsole compound for all-day performance.',
                'description_ar' => 'A technical running silhouette reimagined for urban luxury. Ultra-lightweight mesh upper, carbon-fiber heel counter, and our proprietary UltraFoam midsole compound for all-day performance.',
                'image' => 'images/kicks.jpg',
                'secondary_image' => 'images/vest.jpg',
                'gallery' => [
                    0 => [
                        'image' => 'images/kicks.jpg',
                    ],
                    1 => [
                        'image' => 'images/vest.jpg',
                    ],
                    2 => [
                        'image' => 'images/pack.jpg',
                    ],
                    3 => [
                        'image' => 'images/archive-overshirt.jpg',
                    ],
                ],
                'finishes' => [
                    0 => [
                        'color' => '#1b1c1c',
                        'label' => 'Stealth Black',
                    ],
                    1 => [
                        'color' => '#fbf9f8',
                        'label' => 'Cloud White',
                    ],
                ],
                'sizes' => [
                    0 => 'UK 7',
                    1 => 'UK 8',
                    2 => 'UK 9',
                    3 => 'UK 10',
                    4 => 'UK 11',
                ],
                'trust' => [
                    0 => [
                        'icon' => 'local_shipping',
                        'label' => 'Free Shipping',
                    ],
                    1 => [
                        'icon' => 'verified_user',
                        'label' => '1-Year Guarantee',
                    ],
                    2 => [
                        'icon' => 'lock',
                        'label' => 'Secure Checkout',
                    ],
                ],
                'accordions' => [
                    0 => [
                        'title' => 'MATERIALS',
                        'content' => 'Engineered mesh upper. Carbon-fiber heel counter. UltraFoam midsole. Rubber outsole.',
                    ],
                    1 => [
                        'title' => 'FIT & SIZING',
                        'content' => 'True-to-size. Available in UK 7–11. Half sizes not available — size up if between sizes.',
                    ],
                    2 => [
                        'title' => 'SHIPPING & RETURNS',
                        'content' => 'Complimentary global insured shipping. 30-day return policy. Unworn condition required.',
                    ],
                ],
                'is_best_seller' => true,
                'in_collections' => false,
                'is_archive_featured' => false,
                'in_archive' => false,
                'labels' => [
                    0 => 'best_seller',
                    1 => 'new_arrival',
                ],
                'sort_order' => 8,
            ],
            8 => [
                'slug' => 'archival-heavyweight-hoodie',
                'name_en' => 'ARCHIVAL HEAVYWEIGHT HOODIE',
                'name_ar' => 'ARCHIVAL HEAVYWEIGHT HOODIE',
                'category' => 'hoodies-4',
                'subtitle_en' => 'JAPANESE FRENCH TERRY / CARBON GREY',
                'subtitle_ar' => 'JAPANESE FRENCH TERRY / CARBON GREY',
                'price' => 285.0,
                'original_price' => null,
                'badge' => null,
                'description_en' => 'Woven from loopback Japanese French Terry at 520gsm — the weight of intention. Garment-dyed and enzyme-washed for a lived-in texture that improves with each wear.',
                'description_ar' => 'Woven from loopback Japanese French Terry at 520gsm — the weight of intention. Garment-dyed and enzyme-washed for a lived-in texture that improves with each wear.',
                'image' => 'images/archive-hoodie.jpg',
                'secondary_image' => 'images/hoodies.jpg',
                'gallery' => [
                    0 => [
                        'image' => 'images/archive-hoodie.jpg',
                    ],
                    1 => [
                        'image' => 'images/hoodies.jpg',
                    ],
                ],
                'finishes' => [
                    0 => [
                        'color' => '#444748',
                        'label' => 'Carbon Grey',
                    ],
                    1 => [
                        'color' => '#1b1c1c',
                        'label' => 'Onyx Black',
                    ],
                    2 => [
                        'color' => '#c4b99a',
                        'label' => 'Natural Ecru',
                    ],
                ],
                'sizes' => [
                    0 => 'XS',
                    1 => 'S',
                    2 => 'M',
                    3 => 'L',
                    4 => 'XL',
                    5 => 'XXL',
                ],
                'trust' => [
                    0 => [
                        'icon' => 'local_shipping',
                        'label' => 'Free Shipping',
                    ],
                    1 => [
                        'icon' => 'verified_user',
                        'label' => '2-Year Guarantee',
                    ],
                    2 => [
                        'icon' => 'lock',
                        'label' => 'Secure Checkout',
                    ],
                ],
                'accordions' => [
                    0 => [
                        'title' => 'MATERIALS',
                        'content' => '100% Japanese Cotton French Terry, 520gsm. Garment-dyed and enzyme-washed. Machine wash cold.',
                    ],
                    1 => [
                        'title' => 'FIT',
                        'content' => 'Oversized silhouette. Drop shoulders. Length: 75cm on a size M. Model wears size L.',
                    ],
                    2 => [
                        'title' => 'SHIPPING & RETURNS',
                        'content' => 'Complimentary global insured shipping. 30-day return policy.',
                    ],
                ],
                'is_best_seller' => false,
                'in_collections' => false,
                'is_archive_featured' => true,
                'in_archive' => false,
                'labels' => [
                    0 => 'featured',
                    1 => 'new_arrival',
                ],
                'sort_order' => 9,
            ],
            9 => [
                'slug' => 'sculpted-cotton-tee',
                'name_en' => 'SCULPTED COTTON TEE',
                'name_ar' => 'SCULPTED COTTON TEE',
                'category' => 't-shirts-2',
                'subtitle_en' => 'OPTIC WHITE',
                'subtitle_ar' => 'OPTIC WHITE',
                'price' => 95.0,
                'original_price' => null,
                'badge' => 'Essentials',
                'description_en' => 'Cut from a heavyweight 230gsm Supima Cotton single-jersey, the Sculpted Tee is structured with a subtle side seam taper and extended back hem — engineered to hold its shape wear after wear.',
                'description_ar' => 'Cut from a heavyweight 230gsm Supima Cotton single-jersey, the Sculpted Tee is structured with a subtle side seam taper and extended back hem — engineered to hold its shape wear after wear.',
                'image' => 'images/archive-tshirt.jpg',
                'secondary_image' => 'images/tshirts.jpg',
                'gallery' => [
                    0 => [
                        'image' => 'images/archive-tshirt.jpg',
                    ],
                    1 => [
                        'image' => 'images/tshirts.jpg',
                    ],
                ],
                'finishes' => [
                    0 => [
                        'color' => '#fbf9f8',
                        'label' => 'Optic White',
                    ],
                    1 => [
                        'color' => '#1b1c1c',
                        'label' => 'Onyx Black',
                    ],
                    2 => [
                        'color' => '#444748',
                        'label' => 'Ash Grey',
                    ],
                ],
                'sizes' => [
                    0 => 'XS',
                    1 => 'S',
                    2 => 'M',
                    3 => 'L',
                    4 => 'XL',
                ],
                'trust' => [
                    0 => [
                        'icon' => 'local_shipping',
                        'label' => 'Free Shipping',
                    ],
                    1 => [
                        'icon' => 'verified_user',
                        'label' => '2-Year Guarantee',
                    ],
                    2 => [
                        'icon' => 'lock',
                        'label' => 'Secure Checkout',
                    ],
                ],
                'accordions' => [
                    0 => [
                        'title' => 'MATERIALS',
                        'content' => '100% Supima Cotton, 230gsm. Stone-washed. Machine wash cold inside out.',
                    ],
                    1 => [
                        'title' => 'FIT',
                        'content' => 'Relaxed with tapered waist. Length: 72cm on size M. Model wears size L.',
                    ],
                    2 => [
                        'title' => 'SHIPPING & RETURNS',
                        'content' => 'Complimentary global insured shipping. 30-day return policy.',
                    ],
                ],
                'is_best_seller' => false,
                'in_collections' => false,
                'is_archive_featured' => false,
                'in_archive' => true,
                'labels' => [
                    0 => 'new_arrival',
                ],
                'sort_order' => 10,
            ],
            10 => [
                'slug' => 'technical-overshirt',
                'name_en' => 'TECHNICAL OVERSHIRT',
                'name_ar' => 'TECHNICAL OVERSHIRT',
                'category' => 'outerwear-8',
                'subtitle_en' => 'DEEP NAVY',
                'subtitle_ar' => 'DEEP NAVY',
                'price' => 420.0,
                'original_price' => null,
                'badge' => null,
                'description_en' => 'A precision-constructed overshirt in a 4-way stretch woven technical fabric. YKK concealed placket, underarm articulation panels, and bonded seams deliver an architectural form.',
                'description_ar' => 'A precision-constructed overshirt in a 4-way stretch woven technical fabric. YKK concealed placket, underarm articulation panels, and bonded seams deliver an architectural form.',
                'image' => 'images/archive-overshirt.jpg',
                'secondary_image' => null,
                'gallery' => [
                    0 => [
                        'image' => 'images/archive-overshirt.jpg',
                    ],
                ],
                'finishes' => [
                    0 => [
                        'color' => '#1c2a4a',
                        'label' => 'Deep Navy',
                    ],
                    1 => [
                        'color' => '#1b1c1c',
                        'label' => 'Onyx Black',
                    ],
                ],
                'sizes' => [
                    0 => 'XS',
                    1 => 'S',
                    2 => 'M',
                    3 => 'L',
                    4 => 'XL',
                ],
                'trust' => [
                    0 => [
                        'icon' => 'local_shipping',
                        'label' => 'Free Shipping',
                    ],
                    1 => [
                        'icon' => 'verified_user',
                        'label' => '2-Year Guarantee',
                    ],
                    2 => [
                        'icon' => 'lock',
                        'label' => 'Secure Checkout',
                    ],
                ],
                'accordions' => [
                    0 => [
                        'title' => 'MATERIALS',
                        'content' => '87% Polyamide, 13% Elastane. Water-repellent DWR finish. Machine wash cold.',
                    ],
                    1 => [
                        'title' => 'FIT',
                        'content' => 'Slim silhouette with technical articulation. Length: 82cm on size M.',
                    ],
                    2 => [
                        'title' => 'SHIPPING & RETURNS',
                        'content' => 'Complimentary global insured shipping. 30-day return policy.',
                    ],
                ],
                'is_best_seller' => false,
                'in_collections' => false,
                'is_archive_featured' => false,
                'in_archive' => true,
                'labels' => [
                ],
                'sort_order' => 11,
            ],
            11 => [
                'slug' => 'loro-piana-cashmere-knit',
                'name_en' => 'LORO PIANA CASHMERE KNIT',
                'name_ar' => 'LORO PIANA CASHMERE KNIT',
                'category' => 'knitwear-12',
                'subtitle_en' => 'SANDSTONE',
                'subtitle_ar' => 'SANDSTONE',
                'price' => 1150.0,
                'original_price' => null,
                'badge' => null,
                'description_en' => 'Spun from Grade-A cashmere sourced from the Inner Mongolian highlands and woven at the Loro Piana mill in Quarona, Italy. A knit that only improves with age.',
                'description_ar' => 'Spun from Grade-A cashmere sourced from the Inner Mongolian highlands and woven at the Loro Piana mill in Quarona, Italy. A knit that only improves with age.',
                'image' => 'images/archive-cashmere.jpg',
                'secondary_image' => null,
                'gallery' => [
                    0 => [
                        'image' => 'images/archive-cashmere.jpg',
                    ],
                ],
                'finishes' => [
                    0 => [
                        'color' => '#c4b99a',
                        'label' => 'Sandstone',
                    ],
                    1 => [
                        'color' => '#444748',
                        'label' => 'Ash Grey',
                    ],
                    2 => [
                        'color' => '#5D4A36',
                        'label' => 'Caramel',
                    ],
                ],
                'sizes' => [
                    0 => 'XS',
                    1 => 'S',
                    2 => 'M',
                    3 => 'L',
                    4 => 'XL',
                ],
                'trust' => [
                    0 => [
                        'icon' => 'local_shipping',
                        'label' => 'Free Shipping',
                    ],
                    1 => [
                        'icon' => 'verified_user',
                        'label' => '2-Year Guarantee',
                    ],
                    2 => [
                        'icon' => 'lock',
                        'label' => 'Secure Checkout',
                    ],
                ],
                'accordions' => [
                    0 => [
                        'title' => 'MATERIALS',
                        'content' => '100% Grade-A Cashmere. Dry clean recommended. Do not tumble dry.',
                    ],
                    1 => [
                        'title' => 'FIT',
                        'content' => 'Relaxed silhouette. Ribbed hem and cuffs. Length: 68cm on size M.',
                    ],
                    2 => [
                        'title' => 'SHIPPING & RETURNS',
                        'content' => 'Complimentary global insured shipping. 30-day return policy.',
                    ],
                ],
                'is_best_seller' => false,
                'in_collections' => false,
                'is_archive_featured' => false,
                'in_archive' => true,
                'labels' => [
                    0 => 'new_arrival',
                ],
                'sort_order' => 12,
            ],
            12 => [
                'slug' => 'leather-aviator-jacket',
                'name_en' => 'LEATHER AVIATOR JACKET',
                'name_ar' => 'LEATHER AVIATOR JACKET',
                'category' => 'outerwear-8',
                'subtitle_en' => 'NOIR BLACK',
                'subtitle_ar' => 'NOIR BLACK',
                'price' => 1850.0,
                'original_price' => null,
                'badge' => null,
                'description_en' => 'Hand-stitched from a single hide of full-grain nappa leather in our Florence workshop. The shearling-lined interior and ribbed hem create a jacket that becomes more personal with every wear.',
                'description_ar' => 'Hand-stitched from a single hide of full-grain nappa leather in our Florence workshop. The shearling-lined interior and ribbed hem create a jacket that becomes more personal with every wear.',
                'image' => 'images/archive-jacket.jpg',
                'secondary_image' => null,
                'gallery' => [
                    0 => [
                        'image' => 'images/archive-jacket.jpg',
                    ],
                ],
                'finishes' => [
                    0 => [
                        'color' => '#1b1c1c',
                        'label' => 'Noir Black',
                    ],
                    1 => [
                        'color' => '#5D4A36',
                        'label' => 'Tobacco Brown',
                    ],
                ],
                'sizes' => [
                    0 => 'XS',
                    1 => 'S',
                    2 => 'M',
                    3 => 'L',
                    4 => 'XL',
                ],
                'trust' => [
                    0 => [
                        'icon' => 'local_shipping',
                        'label' => 'Free Shipping',
                    ],
                    1 => [
                        'icon' => 'verified_user',
                        'label' => '5-Year Guarantee',
                    ],
                    2 => [
                        'icon' => 'lock',
                        'label' => 'Secure Checkout',
                    ],
                ],
                'accordions' => [
                    0 => [
                        'title' => 'MATERIALS',
                        'content' => 'Full-grain nappa leather exterior. Genuine shearling lining. YKK hardware. Professional leather clean only.',
                    ],
                    1 => [
                        'title' => 'FIT',
                        'content' => 'Regular fit with ribbed hem and cuffs. Length: 65cm on size M.',
                    ],
                    2 => [
                        'title' => 'SHIPPING & RETURNS',
                        'content' => 'Complimentary global insured shipping. 30-day return policy.',
                    ],
                ],
                'is_best_seller' => false,
                'in_collections' => false,
                'is_archive_featured' => false,
                'in_archive' => true,
                'labels' => [
                    0 => 'limited_edition',
                ],
                'sort_order' => 13,
            ],
            13 => [
                'slug' => 'luxe-aura',
                'name_en' => 'LUXE AURA',
                'name_ar' => 'LUXE AURA',
                'category' => 't-shirts-2',
                'subtitle_en' => 'dsc',
                'subtitle_ar' => 'dsc',
                'price' => 2000.0,
                'original_price' => 2500.0,
                'badge' => 'sdlvm',
                'description_en' => 'سيبلسبيايبابفل',
                'description_ar' => 'سيبلسبيايبابفل',
                'image' => 'products/zE38WH3pDAeKFMw5Kgb1awaMU1XuwKlWsKOA89Gm.png',
                'secondary_image' => 'products/oB3PsJpHrS9K1jxWSYNRpOfZtGHOhN2oWulwlalq.png',
                'gallery' => [
                    0 => [
                        'image' => 'products/oB3PsJpHrS9K1jxWSYNRpOfZtGHOhN2oWulwlalq.png',
                    ],
                    1 => [
                        'image' => 'products/Fc4z2UkR0umMAA2CE2MWUI0p5LCh8RAom9GLTl2h.png',
                    ],
                    2 => [
                        'image' => 'products/0VrBVM3pxJqWclp58UhNGYdnOAUGiYP9P68vuZj2.png',
                    ],
                    3 => [
                        'image' => 'products/m6h6LSbFQfdQSX4Cr0KABOnldI0Y0j8CTyjWNCFx.png',
                    ],
                    4 => [
                        'image' => 'products/kH3Gj4QuqNB1TERrY0cYSRcHME1eFUKbZszpP3be.png',
                    ],
                    5 => [
                        'image' => 'products/ehUi2zDu16ncuGUwFRrlybhesGsxNEdLQOqlTGoO.png',
                    ],
                ],
                'finishes' => [
                    0 => [
                        'color' => '#000000',
                        'label' => 'BLACK',
                    ],
                    1 => [
                        'color' => '#ffffff',
                        'label' => 'W',
                    ],
                    2 => [
                        'color' => '#ff0000',
                        'label' => 'RED',
                    ],
                ],
                'sizes' => [
                    0 => 'M',
                    1 => 'L',
                    2 => 'XL',
                ],
                'trust' => [
                ],
                'accordions' => [
                ],
                'is_best_seller' => false,
                'in_collections' => false,
                'is_archive_featured' => false,
                'in_archive' => false,
                'labels' => [
                    0 => 'best_seller',
                ],
                'sort_order' => 18,
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(['slug' => $product['slug']], $product);
        }
    }
}
