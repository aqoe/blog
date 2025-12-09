<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'category_id' => 1,
                'title' => 'Почему я выбрал Laravel',
                'slug' => 'pochemu-ya-vybral-laravel',
                'excerpt' => 'Рассказываю о своём опыте изучения PHP-фреймворков',
                'content' => 'Laravel — это потрясающий фреймворк! Он имеет отличную документацию, большое сообщество и множество готовых решений. В этой статье я расскажу, почему остановился именно на нём.',
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'category_id' => 2,
                'title' => 'Моё путешествие в горы',
                'slug' => 'moe-puteshestvie-v-gory',
                'excerpt' => 'Незабываемый поход на выходных',
                'content' => 'В прошлые выходные я отправился в горы. Погода была прекрасной, виды — потрясающими. Обязательно повторю этот опыт!',
                'is_published' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'category_id' => 3,
                'title' => 'Как я организую свой день',
                'slug' => 'kak-ya-organizuyu-svoj-den',
                'excerpt' => 'Делюсь своими секретами продуктивности',
                'content' => 'Правильное планирование — ключ к успеху. Я использую простой метод: утром — сложные задачи, вечером — рутина. И обязательно делаю перерывы!',
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],
        ];

        foreach ($posts as $post) {
            Post::create($post);
        }
    }
}