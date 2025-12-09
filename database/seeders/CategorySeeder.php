<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'music', 'slug' => 'music'],
            ['name' => 'books', 'slug' => 'books'],
            ['name' => 'essays', 'slug' => 'essays'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}