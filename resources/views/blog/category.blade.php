@extends('layouts.app')

@section('title', $category->name)

@section('content')
    <div class="min-h-screen px-4 py-16">
        
        <!-- Назад -->
        <a href="/" class="fixed top-8 left-8 text-gray-400 hover:text-gray-800 smooth">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        
        <!-- Название категории -->
        <h1 class="text-center text-sm tracking-widest text-gray-400 mb-16 uppercase">
            {{ $category->name }}
        </h1>
        
        <!-- Список постов -->
        <!-- Список постов -->
        <div class="max-w-2xl mx-auto space-y-8">
            @foreach($posts as $post)
                <article class="post-card group cursor-pointer border-b border-gray-100 pb-8"
                        onclick="openPost({{ $post->id }})">
                    <h2 class="text-xl md:text-2xl font-light text-gray-800 group-hover:text-gray-500 smooth">
                        {{ $post->title }}
                    </h2>
                    @if($post->excerpt)
                        <p class="mt-2 text-gray-400 font-light">
                            {{ $post->excerpt }}
                        </p>
                    @endif
                </article>
            @endforeach
        </div>
        
    </div>

    <!-- Модальное окно для поста -->
    <div id="postModal" class="fixed inset-0 bg-white z-50 hidden">
        <div class="h-full overflow-hidden">
            
            <!-- Кнопка закрыть -->
            <button onclick="closePost()" class="fixed top-8 left-8 text-gray-400 hover:text-gray-800 smooth z-50">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            
            <!-- Навигация влево/вправо -->
            <button onclick="prevPost()" class="fixed left-8 top-1/2 -translate-y-1/2 text-gray-300 hover:text-gray-800 smooth z-50">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            
            <button onclick="nextPost()" class="fixed right-8 top-1/2 -translate-y-1/2 text-gray-300 hover:text-gray-800 smooth z-50">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
            
            <!-- Контент поста -->
            <div id="postContent" class="h-full overflow-y-auto px-8 md:px-16 lg:px-32 py-24">
                <!-- Сюда загрузится пост -->
            </div>
            
        </div>
    </div>

    <script>
        const posts = @json($posts);
        let currentIndex = 0;
        
        function openPost(postId) {
            currentIndex = posts.findIndex(p => p.id === postId);
            showCurrentPost();
            document.getElementById('postModal').classList.remove('hidden');
            document.getElementById('postModal').classList.add('fade-in');
            document.body.style.overflow = 'hidden';
        }
        
        function closePost() {
            document.getElementById('postModal').classList.add('hidden');
            document.body.style.overflow = '';
        }
        
        function showCurrentPost() {
            const post = posts[currentIndex];

            let imageHtml = '';
            if (post.image) {
                imageHtml = `
                    <div class="mt-10">
                        <div class="w-full aspect-square overflow-hidden">
                            <img 
                                src="/storage/${post.image}"
                                class="w-full h-full object-cover"
                                alt="${post.title}">
                        </div>
                    </div>
                `;
            }

            const content = `
                <article class="max-w-2xl mx-auto fade-in">
                    <h1 class="text-2xl md:text-4xl font-light text-gray-800 mb-8 text-center">
                        ${post.title}
                    </h1>

                    <div class="text-gray-600 font-light leading-relaxed whitespace-pre-line">
                        ${post.content}
                    </div>

                    ${imageHtml}
                </article>
            `;

            document.getElementById('postContent').innerHTML = content;
        }

        
        function prevPost() {
            if (currentIndex > 0) {
                currentIndex--;
                showCurrentPost();
            }
        }
        
        function nextPost() {
            if (currentIndex < posts.length - 1) {
                currentIndex++;
                showCurrentPost();
            }
        }
        
        // Клавиши влево/вправо и Escape
        document.addEventListener('keydown', (e) => {
            if (document.getElementById('postModal').classList.contains('hidden')) return;
            
            if (e.key === 'ArrowLeft') prevPost();
            if (e.key === 'ArrowRight') nextPost();
            if (e.key === 'Escape') closePost();
        });
        
        // Свайп на мобильных
        let touchStartX = 0;
        document.getElementById('postModal').addEventListener('touchstart', (e) => {
            touchStartX = e.touches[0].clientX;
        });
        
        document.getElementById('postModal').addEventListener('touchend', (e) => {
            const touchEndX = e.changedTouches[0].clientX;
            const diff = touchStartX - touchEndX;
            
            if (Math.abs(diff) > 50) {
                if (diff > 0) nextPost();
                else prevPost();
            }
        });
    </script>
@endsection