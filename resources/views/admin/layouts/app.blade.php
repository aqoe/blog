<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    
    <div class="flex">
        <!-- Боковое меню -->
        <aside class="w-64 bg-gray-800 min-h-screen p-4">
            <h1 class="text-white text-xl font-bold mb-8">📝 Админка</h1>
            
            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" 
                   class="block px-4 py-2 text-gray-300 hover:bg-gray-700 rounded">
                    🏠 Главная
                </a>
                <a href="{{ route('admin.posts.index') }}" 
                   class="block px-4 py-2 text-gray-300 hover:bg-gray-700 rounded">
                    📄 Посты
                </a>
                <a href="{{ route('admin.categories.index') }}" 
                   class="block px-4 py-2 text-gray-300 hover:bg-gray-700 rounded">
                    🏷️ Категории
                </a>
                <a href="/" target="_blank"
                   class="block px-4 py-2 text-gray-300 hover:bg-gray-700 rounded">
                    🌐 Открыть сайт
                </a>
            </nav>
        </aside>

        <!-- Контент -->
        <main class="flex-1 p-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</body>
</html>