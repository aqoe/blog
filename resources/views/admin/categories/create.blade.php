@extends('admin.layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Новая категория</h1>

    <form action="{{ route('admin.categories.store') }}" method="POST" 
          class="bg-white rounded-lg shadow p-6 max-w-lg">
        @csrf

        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">Название</label>
            <input type="text" name="name" value="{{ old('name') }}"
                   class="w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror"
                   placeholder="Например: Технологии">
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex space-x-4">
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                Создать
            </button>
            <a href="{{ route('admin.categories.index') }}" class="text-gray-600 hover:underline py-2">
                Отмена
            </a>
        </div>
    </form>
@endsection