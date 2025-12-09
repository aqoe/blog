@extends('layouts.app')

@section('title', 'o\'bert')

@section('content')
    <div class="min-h-screen flex flex-col items-center justify-center px-4">
        
        <!-- Название блога -->
        <h1 class="text-sm tracking-widest text-gray-400 mb-16 uppercase">
            o'bert
        </h1>
        
        <!-- Категории -->
        <nav class="space-y-6 text-center">
            @foreach($categories as $category)
                <a href="{{ route('category.show', $category->slug) }}" 
                   class="category-link block text-2xl md:text-4xl font-light tracking-wide text-gray-800 hover:text-gray-500 smooth">
                    {{ $category->name }}
                </a>
            @endforeach
        </nav>
        
    </div>
@endsection