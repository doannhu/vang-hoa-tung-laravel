<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Catalogue;
use Illuminate\Support\Facades\Storage;

class CatalogueSeeder extends Seeder
{
    public function run(): void
    {
        // Create sample catalogues
        $catalogues = [
            [
                'title' => 'Nhẫn Cưới',
                'subtitle' => 'Bộ sưu tập nhẫn cưới mới nhất',
                'description' => 'Khám phá bộ sưu tập nhẫn cưới độc đáo, từ thiết kế cổ điển đến hiện đại. Mỗi chiếc nhẫn đều được chế tác tinh xảo, thể hiện tình yêu vĩnh cửu.',
                'features' => [
                    'Chất liệu vàng 24K',
                    'Thiết kế độc quyền',
                    'Đá quý tự nhiên',
                    'Bảo hành trọn đời'
                ],
                'order' => 1,
                'is_active' => true,
                'image_path' => 'catalogues/nhan-cuoi.jpg'
            ],
            [
                'title' => 'Trang Sức Nữ',
                'subtitle' => 'Tôn vinh vẻ đẹp phái nữ',
                'description' => 'Bộ sưu tập trang sức nữ với thiết kế tinh tế, kết hợp giữa truyền thống và hiện đại. Từ dây chuyền, bông tai đến vòng tay, mỗi món trang sức đều mang đến vẻ đẹp riêng biệt.',
                'features' => [
                    'Đa dạng mẫu mã',
                    'Chất liệu cao cấp',
                    'Giá cả hợp lý',
                    'Dịch vụ tư vấn chuyên nghiệp'
                ],
                'order' => 2,
                'is_active' => true,
                'image_path' => 'catalogues/trang-suc-nu.jpg'
            ],
            [
                'title' => 'Trang Sức Nam',
                'subtitle' => 'Phong cách đẳng cấp',
                'description' => 'Khám phá bộ sưu tập trang sức nam với thiết kế mạnh mẽ, sang trọng. Từ nhẫn, dây chuyền đến đồng hồ, mỗi món trang sức đều thể hiện đẳng cấp và phong cách riêng.',
                'features' => [
                    'Thiết kế nam tính',
                    'Chất liệu bền bỉ',
                    'Phong cách đa dạng',
                    'Phù hợp mọi dịp'
                ],
                'order' => 3,
                'is_active' => true,
                'image_path' => 'catalogues/trang-suc-nam.jpg'
            ]
        ];

        // Create catalogues directory if it doesn't exist
        if (!Storage::disk('public')->exists('catalogues')) {
            Storage::disk('public')->makeDirectory('catalogues');
        }

        // Create each catalogue
        foreach ($catalogues as $catalogue) {
            Catalogue::create($catalogue);
        }
    }
} 