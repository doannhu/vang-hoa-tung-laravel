<?php

namespace Database\Seeders;

use App\Models\FeaturedProduct;
use Illuminate\Database\Seeder;

class FeaturedProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FeaturedProduct::create([
            'title' => 'Nhẫn vàng 24K',
            'description' => 'Nhẫn vàng 24K cao cấp',
            'image_path' => 'featured-products/nhan-hot.jpg',
            'link' => 'https://www.facebook.com/vanghoatung',
            'order' => 1,
            'is_active' => true,
        ]);

        FeaturedProduct::create([
            'title' => 'Lắc tay vàng 18K',
            'description' => 'Lắc tay thời trang',
            'image_path' => 'featured-products/lac-tay-moi.jpg',
            'link' => 'https://www.facebook.com/vanghoatung',
            'order' => 2,
            'is_active' => true,
        ]);

        FeaturedProduct::create([
            'title' => 'Dây chuyền vàng 18K',
            'description' => 'Dây chuyền vàng 18K thời trang',
            'image_path' => 'featured-products/day-vang-dep-thang.jpg',
            'link' => 'https://www.facebook.com/vanghoatung',
            'order' => 2,
            'is_active' => true,
        ]);
    }
} 