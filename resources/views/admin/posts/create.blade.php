@extends('admin.layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Новый пост</h1>

    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Заголовок</label>
            <input type="text" name="title" value="{{ old('title') }}"
                   class="w-full border rounded px-3 py-2 @error('title') border-red-500 @enderror">
            @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Категория</label>
            <select name="category_id" class="w-full border rounded px-3 py-2">
                <option value="">Без категории</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Изображение</label>
            <input type="file" name="image" accept="image/*"
                   class="w-full border rounded px-3 py-2 @error('image') border-red-500 @enderror">
            @error('image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-gray-400 text-sm mt-1">JPG, PNG до 2MB</p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Краткое описание</label>
            <textarea name="excerpt" rows="2"
                      class="w-full border rounded px-3 py-2">{{ old('excerpt') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Содержание</label>
            <textarea name="content" rows="10"
                      class="w-full border rounded px-3 py-2 @error('content') border-red-500 @enderror">{{ old('content') }}</textarea>
            @error('content')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="flex items-center">
                <input type="checkbox" name="is_published" class="mr-2">
                <span class="text-gray-700">Опубликовать сразу</span>
            </label>
        </div>

        <div class="flex space-x-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Создать
            </button>
            <a href="{{ route('admin.posts.index') }}" class="text-gray-600 hover:underline py-2">
                Отмена
            </a>
        </div>
    </form>
@endsection