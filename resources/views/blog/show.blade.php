@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <article class="bg-white rounded-lg shadow p-8">
        <h1 class="text-3xl font-bold mb-4">{{ $post->title }}</h1>
        
        <div class="text-gray-500 mb-6">
            {{ $post->published_at->format('d.m.Y') }}
            
            @if($post->category)
                • <a href="{{ route('category.show', $post->category->slug) }}" class="text-blue-600 hover:underline">
                    {{ $post->category->name }}
                </a>
            @endif
        </div>

        @if($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" class="rounded-lg mb-6 w-full">
        @endif

        <div class="prose max-w-none">
            {!! nl2br(e($post->content)) !!}
        </div>
    </article>

    <a href="/" class="inline-block mt-6 text-blue-600 hover:underline">
        ← Назад к записям
    </a>
@endsection