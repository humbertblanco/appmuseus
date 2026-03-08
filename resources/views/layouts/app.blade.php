<!DOCTYPE html>
<html lang="{{ $idioma ?? config('museum.default_locale', 'ca') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('museum.name', 'Museum Audioguide'))</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Dynamic primary color from config/museum.php --}}
    <style>{!! \App\Helpers\ColorHelper::getCssVariables() !!}</style>

    <style>
        [x-cloak] { display: none !important; }

        /* High contrast mode */
        .high-contrast {
            --tw-bg-opacity: 1;
        }
        .high-contrast body {
            background-color: #000 !important;
            color: #fff !important;
        }
        .high-contrast .bg-white,
        .high-contrast .bg-gray-50,
        .high-contrast .bg-gray-100 {
            background-color: #000 !important;
            color: #fff !important;
        }
        .high-contrast .text-gray-600,
        .high-contrast .text-gray-700,
        .high-contrast .text-gray-500,
        .high-contrast .text-gray-400,
        .high-contrast .text-gray-900 {
            color: #fff !important;
        }
        .high-contrast a {
            color: #ffff00 !important;
        }
        .high-contrast .border-gray-200,
        .high-contrast .border-gray-100 {
            border-color: #fff !important;
        }
        .high-contrast .bg-gray-800 {
            background-color: #333 !important;
        }
    </style>
</head>
<body class="min-h-screen bg-gray-50 font-sans">
    <div class="flex flex-col min-h-screen">
        @include('components.header')

        <main class="flex-1">
            @yield('content')
        </main>

        @include('components.footer')
    </div>

    <!-- Widget d'accessibilitat -->
    @include('components.accessibility-widget', ['idioma' => $idioma ?? config('museum.default_locale', 'ca')])

    @stack('scripts')
</body>
</html>
