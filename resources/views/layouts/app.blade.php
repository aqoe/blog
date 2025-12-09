<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'o\'bert')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * {
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', sans-serif;
        }
        
        /* Анимация появления */
        /* .fade-in {
            animation: fadeIn 0.3s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        } */

        .fade-in {
            animation: articleEnter 0.45s cubic-bezier(.2,.8,.2,1) both;
            will-change: opacity, transform;
        }

        @keyframes articleEnter {
            0% {
                opacity: 0;
                transform: scale(0.97);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        
        /* Плавные переходы */
        .smooth {
            transition: all 0.3s ease;
        }
        
        /* Ховер на категориях */
        .category-link:hover,
        .category-link:focus-visible {
        text-decoration: underline;
        }

        .category-link,
        .category-link:hover,
        .category-link:focus,
        .category-link:active {
            color: inherit !important;
        }

        .category-link:hover,
        .category-link:focus-visible {
            text-decoration: underline !important;
        }


    </style>
</head>
<body class="bg-white text-gray-900 min-h-screen">
    @yield('content')
</body>
</html>