<header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <a href="{{ route('home.idioma', ['idioma' => $idioma ?? config('museum.default_locale', 'ca')]) }}" class="flex items-center">
                @if(file_exists(public_path(config('museum.logo', 'images/logo.png'))))
                    <img
                        src="/{{ config('museum.logo', 'images/logo.png') }}"
                        alt="{{ config('museum.name', 'Museum Audioguide') }}"
                        class="h-14 w-auto"
                    >
                @else
                    <span class="text-xl font-bold text-gray-900">{{ config('museum.name', 'Museum Audioguide') }}</span>
                @endif
            </a>

            @include('components.language-selector')
        </div>
    </div>
</header>
