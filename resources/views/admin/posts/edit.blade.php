@extends('admin.layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Редактировать пост</h1>

    <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Заголовок</label>
            <input type="text" name="title" value="{{ old('title', $post->title) }}"
                   class="w-full border rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Категория</label>
            <select name="category_id" class="w-full border rounded px-3 py-2">
                <option value="">Без категории</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" 
                            {{ $post->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Изображение</label>
            
            @if($post->image)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $post->image) }}" 
                         class="w-48 h-32 object-cover rounded border">
                    <label class="flex items-center mt-2">
                        <input type="checkbox" name="remove_image" class="mr-2">
                        <span class="text-red-600 text-sm">Удалить изображение</span>
                    </label>
                </div>
            @endif
            
            <input type="file" name="image" accept="image/*"
                   class="w-full border rounded px-3 py-2">
            <p class="text-gray-400 text-sm mt-1">JPG, PNG до 2MB. Оставьте пустым, чтобы сохранить текущее.</p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Краткое описание</label>
            <textarea name="excerpt" rows="2"
                      class="w-full border rounded px-3 py-2">{{ old('excerpt', $post->excerpt) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Содержание</label>
            <textarea name="content" rows="10"
                      class="w-full border rounded px-3 py-2">{{ old('content', $post->content) }}</textarea>
        </div>

        <div class="mb-6">
            <label class="flex items-center">
                <input type="checkbox" name="is_published" class="mr-2"
                       {{ $post->is_published ? 'checked' : '' }}>
                <span class="text-gray-700">Опубликован</span>
            </label>
        </div>

        <div class="flex space-x-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Сохранить
            </button>
            <a href="{{ route('admin.posts.index') }}" class="text-gray-600 hover:underline py-2">
                Отмена
            </a>
        </div>
    </form>
@endsection