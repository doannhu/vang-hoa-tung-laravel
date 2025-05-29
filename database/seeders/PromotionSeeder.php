<?php

namespace Database\Seeders;

use App\Models\Promotion;
use Illuminate\Database\Seeder;

class PromotionSeeder extends Seeder
{
    public function run()
    {
        $promotions = [
            [
                'title' => 'Quà Tết Cuối Năm',
                'description' => 'Nhận ngay quà tặng giá trị khi mua hàng dịp Tết',
                'image_path' => 'promotions/qua-tet.png',
                'link' => '#',
                'order' => 1,
                'is_active' => true
            ],
            [
                'title' => 'Mũ bảo hiểm chất lượng cao',
                'description' => 'Tặng mũ bảo hiểm cao cấp khi mua trang sức',
                'image_path' => 'promotions/mu-bao-hiem.png',
                'link' => '#',
                'order' => 2,
                'is_active' => true
            ],
            [
                'title' => 'Lì xì thần tài đầu năm',
                'description' => 'Nhận lì xì may mắn khi mua hàng đầu năm',
                'image_path' => 'promotions/than-tai.png',
                'link' => '#',
                'order' => 3,
                'is_active' => true
            ],
            [
                'title' => 'Ưu đãi khi mua số lượng lớn',
                'description' => 'Giảm giá đặc biệt cho khách hàng mua số lượng lớn',
                'image_path' => 'promotions/uu-dai-mua-nhieu.png',
                'link' => '#',
                'order' => 4,
                'is_active' => true
            ],
            [
                'title' => 'Miễn phí ship nội thành',
                'description' => 'Miễn phí vận chuyển cho đơn hàng nội thành',
                'image_path' => 'promotions/mien-phi-ship.png',
                'link' => '#',
                'order' => 5,
                'is_active' => true
            ],
            [
                'title' => 'Lịch thuận buồm xuôi gió',
                'description' => 'Tặng lịch độc quyền khi mua hàng',
                'image_path' => 'promotions/lich.png',
                'link' => '#',
                'order' => 6,
                'is_active' => true
            ]
        ];

        foreach ($promotions as $promotion) {
            Promotion::create($promotion);
        }
    }
} 