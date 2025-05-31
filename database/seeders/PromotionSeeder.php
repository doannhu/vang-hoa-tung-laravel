<?php

namespace Database\Seeders;

use App\Models\Promotion;
use Illuminate\Database\Seeder;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Promotion::create([
            'title' => 'Khuyến mãi tháng 5',
            'description' => 'Giảm giá 20% cho tất cả sản phẩm',
            'image_path' => 'promotions/giam-gia-mua-theo-bo.jpg',
            'link' => 'https://www.facebook.com/vanghoatung',
            'order' => 1,
            'is_active' => true,
        ]);

        Promotion::create([
            'title' => 'Chương trình sinh nhật',
            'description' => 'Tặng quà sinh nhật cho khách hàng',
            'image_path' => 'promotions/tang-qua-dip-le.jpg',
            'link' => 'https://www.facebook.com/vanghoatung',
            'order' => 2,
            'is_active' => true,
        ]);

        Promotion::create([
            'title' => 'Giảm giá khi mua nhiều',
            'description' => 'Tặng 10% giá trị khi mua trên 3 sản phẩm',
            'image_path' => 'promotions/mua-so-luong-lon.jpg',
            'link' => 'https://www.facebook.com/vanghoatung',
            'order' => 3,
            'is_active' => true,
        ]);
    }
} 