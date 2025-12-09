@extends('admin.layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Посты</h1>
        <a href="{{ route('admin.posts.create') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Новый пост
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-gray-700">Заголовок</th>
                    <th class="px-6 py-3 text-left text-gray-700">Категория</th>
                    <th class="px-6 py-3 text-left text-gray-700">Статус</th>
                    <th class="px-6 py-3 text-right text-gray-700">Действия</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($posts as $post)
                    <tr>
                        <td class="px-6 py-4">{{ $post->title }}</td>
                        <td class="px-6 py-4 text-gray-500">
                            {{ $post->category?->name ?? '—' }}
                        </td>
                        <td class="px-6 py-4">
                            @if($post->is_published)
                                <span class="text-green-600">✓ Опубликован</span>
                            @else
                                <span class="text-gray-400">Черновик</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.posts.edit', $post) }}" 
                               class="text-blue-600 hover:underline">Изменить</a>
                            
                            <form action="{{ route('admin.posts.destroy', $post) }}" 
                                  method="POST" 
                                  class="inline"
                                  onsubmit="return confirm('Удалить пост?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">
                                    Удалить
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                            Нет постов
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $posts->links() }}
    </div>
@endsection