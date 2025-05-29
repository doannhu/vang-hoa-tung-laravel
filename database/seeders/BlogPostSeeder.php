<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogPost;

class BlogPostSeeder extends Seeder
{
    public function run()
    {
        $posts = [
            [
                'title' => 'Thiện Nguyện Hàng Năm',
                'description' => 'Hằng năm Hoa Tùng đóng góp cho các tổ chức trẻ em, thương binh và các hoàn cảnh khó khăn trong địa phương. Hoa Tùng hiểu rõ đây là trách nhiệm của mỗi doanh nghiệp, cùng chung tay đóng góp vì sự phát triển của xã hội.',
                'image_path' => 'blog_posts/thien-nguyen.png',
                'link' => 'https://www.facebook.com/vanghoatung',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Lưu giữ nét đẹp văn hoá',
                'description' => 'Hàng năm, chúng tôi tổ chức nhiều sự kiện truyền thống như vui trung thu, ngày của mẹ, ngày phụ nữ, Valentine, và quốc tế thiếu nhi... Những sự kiện này không chỉ tạo nên không khí lễ hội, mà còn là cơ hội để cộng đồng tận hưởng những khoảnh khắc đáng nhớ.',
                'image_path' => 'blog_posts/le-hoi.png',
                'link' => 'https://www.facebook.com/vanghoatung',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Tuyển dụng',
                'description' => 'Hoa Tùng rất cần bạn, một người đáng tin và dễ thương. Ham học hỏi và không ngại thay đổi bản thân để cùng nhau phát triển và mở rộng.',
                'image_path' => 'blog_posts/tuyen-dung.png',
                'link' => 'https://www.facebook.com/vanghoatung',
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($posts as $post) {
            BlogPost::create($post);
        }
    }
} 