<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogPost;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BlogPost::create([
            'title' => 'Lì xì năm mới',
            'description' => 'Bài viết hướng dẫn cách chọn trang sức phù hợp với từng dịp.',
            'image_path' => 'blog_posts/li-xi-nam-moi.jpg',
            'link' => 'https://www.facebook.com/vanghoatung',
            'order' => 1,
            'is_active' => true,
        ]);

        BlogPost::create([
            'title' => 'Thiện nguyện',
            'description' => 'Trong hành trình xây dựng một xã hội không ai bị bỏ lại phía sau, Hoa Tùng âm thầm chắp cánh cho những mái ấm vững chãi và thắp sáng hy vọng cho những mảnh đời khó khăn - bởi chỉ khi cùng nâng đỡ nhau, chúng ta mới thực sự tiến bước.',
            'image_path' => 'blog_posts/tu-thien.jpg',
            'link' => 'https://www.facebook.com/vanghoatung',
            'order' => 2,
            'is_active' => true,
        ]);

        BlogPost::create([
            'title' => 'Xu hướng trang sức 2024',
            'description' => 'Hằng năm Hoa Tùng đóng góp cho các tổ chức trẻ em, thương binh và hoạt động xã hội trong địa phương. Hoa Tùng hiểu rõ đây là trách nhiệm của mỗi doanh nghiệp, cùng chung tay đóng góp vì sự phát triển của xã hội.',
            'image_path' => 'blog_posts/tuyen-dung.jpg',
            'link' => 'https://www.facebook.com/vanghoatung',
            'order' => 2,
            'is_active' => true,
        ]);
    }
} 