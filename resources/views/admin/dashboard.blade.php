@extends('admin.layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Добро пожаловать!</h1>
    
    <div class="grid grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold text-gray-700">Постов</h2>
            <p class="text-3xl font-bold text-blue-600">{{ \App\Models\Post::count() }}</p>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold text-gray-700">Категорий</h2>
            <p class="text-3xl font-bold text-green-600">{{ \App\Models\Category::count() }}</p>
        </div>
    </div>
@endsection