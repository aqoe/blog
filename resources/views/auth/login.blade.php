<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * {
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', sans-serif;
        }
    </style>
</head>
<body class="bg-white min-h-screen flex items-center justify-center">
    
    <div class="w-full max-w-sm px-8">
        
        <h1 class="text-center text-sm tracking-widest text-gray-400 mb-12 uppercase">
            Вход
        </h1>

        @if($errors->any())
            <div class="mb-6 text-center text-red-500 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div>
                <input type="email" name="email" value="{{ old('email') }}"
                       placeholder="Email"
                       class="w-full border-b border-gray-200 py-3 text-gray-800 placeholder-gray-400 focus:border-gray-800 focus:outline-none transition-colors">
            </div>

            <div>
                <input type="password" name="password"
                       placeholder="Пароль"
                       class="w-full border-b border-gray-200 py-3 text-gray-800 placeholder-gray-400 focus:border-gray-800 focus:outline-none transition-colors">
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="remember" id="remember" class="mr-2">
                <label for="remember" class="text-gray-400 text-sm">Запомнить меня</label>
            </div>

            <button type="submit" 
                    class="w-full py-3 text-gray-800 border border-gray-800 hover:bg-gray-800 hover:text-white transition-colors">
                Войти
            </button>
        </form>

        <a href="/" class="block text-center mt-8 text-gray-400 hover:text-gray-800 text-sm transition-colors">
            ← На сайт
        </a>

    </div>

</body>
</html>