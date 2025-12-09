<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
    // Главная страница
    public function index()
{
    $categories = Category::has('posts')->get();
    
    return view('blog.index', compact('categories'));
}

    // Отдельный пост
    public function show($slug)
    {
        $post = Post::where('slug', $slug)
            ->published()
            ->firstOrFail();

        return view('blog.show', compact('post'));
    }

    // Посты категории
    public function category($slug)
{
    $category = Category::where('slug', $slug)->firstOrFail();
    
    $posts = Post::where('category_id', $category->id)
        ->published()
        ->latest('published_at')
        ->get(); // Убрали paginate, нужны все посты для свайпа

    return view('blog.category', compact('category', 'posts'));
}
}