@extends('layouts.app')

@section('title', config('museum.name', 'Museum Audioguide'))

@section('content')
{{-- Hero Section --}}
<div class="bg-gradient-to-br from-gray-900 via-gray-800 to-red-900 text-white py-16 md:py-20 lg:py-24 relative overflow-hidden">
    {{-- Decorative pattern --}}
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="lg:grid lg:grid-cols-2 lg:gap-12 lg:items-center">
            {{-- Text column --}}
            <div class="text-center lg:text-left">
                {{-- Headphones icon --}}
                <div class="mx-auto lg:mx-0 w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mb-6 backdrop-blur-sm">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 010 12.728M16.463 8.288a5.25 5.25 0 010 7.424M6.75 8.25l4.72-4.72a.75.75 0 011.28.53v15.88a.75.75 0 01-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.01 9.01 0 012.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75z" />
                    </svg>
                </div>

                <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold mb-4 tracking-wide">
                    @switch($idioma)
                        @case('es') Audioguias @break
                        @case('en') Audio Guides @break
                        @case('fr') Audioguides @break
                        @default Audioguies
                    @endswitch
                    {{ config('museum.institution', '') }}
                </h1>

                <p class="text-lg md:text-xl text-gray-300 max-w-2xl mx-auto lg:mx-0 mb-10">
                    @switch($idioma)
                        @case('es') Descubre el patrimonio a traves de audioguias interactivas @break
                        @case('en') Discover the heritage through interactive audio guides @break
                        @case('fr') Decouvrez le patrimoine grace aux audioguides interactifs @break
                        @default Descobreix el patrimoni a traves d'audioguies interactives
                    @endswitch
                </p>

                {{-- Stats badges --}}
                <div class="flex flex-wrap justify-center lg:justify-start gap-3 md:gap-4">
                    <div class="flex items-center gap-2 bg-white/10 backdrop-blur-sm px-4 py-2.5 lg:px-5 lg:py-3 rounded-full">
                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span class="text-sm lg:text-base font-medium">{{ $exposicions->count() }}
                            @switch($idioma)
                                @case('es') exposiciones @break
                                @case('en') exhibitions @break
                                @case('fr') expositions @break
                                @default exposicions
                            @endswitch
                        </span>
                    </div>
                    <div class="hidden md:block w-px h-6 bg-white/20 self-center"></div>
                    <div class="flex items-center gap-2 bg-white/10 backdrop-blur-sm px-4 py-2.5 lg:px-5 lg:py-3 rounded-full">
                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="text-sm lg:text-base font-medium">{{ $totalPeces }}
                            @switch($idioma)
                                @case('es') espacios @break
                                @case('en') spaces @break
                                @case('fr') espaces @break
                                @default espais
                            @endswitch
                        </span>
                    </div>
                    <div class="hidden md:block w-px h-6 bg-white/20 self-center"></div>
                    <div class="flex items-center gap-2 bg-white/10 backdrop-blur-sm px-4 py-2.5 lg:px-5 lg:py-3 rounded-full">
                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                        </svg>
                        <span class="text-sm lg:text-base font-medium">4
                            @switch($idioma)
                                @case('es') idiomas @break
                                @case('en') languages @break
                                @case('fr') langues @break
                                @default idiomes
                            @endswitch
                        </span>
                    </div>
                </div>
            </div>

            {{-- Decorative illustration (desktop only) --}}
            <div class="hidden lg:flex items-center justify-center">
                <div class="relative w-80 h-80">
                    {{-- Cercles decoratius --}}
                    <div class="absolute inset-0 rounded-full border-2 border-white/10 animate-pulse"></div>
                    <div class="absolute inset-6 rounded-full border-2 border-white/5"></div>
                    <div class="absolute inset-12 rounded-full bg-white/5 backdrop-blur-sm flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-20 h-20 mx-auto text-red-400/80 mb-3" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z" />
                            </svg>
                            <div class="flex items-center justify-center gap-1">
                                <span class="w-1 h-4 bg-red-400/60 rounded-full animate-pulse"></span>
                                <span class="w-1 h-6 bg-red-400/80 rounded-full animate-pulse" style="animation-delay: 0.1s;"></span>
                                <span class="w-1 h-8 bg-red-400 rounded-full animate-pulse" style="animation-delay: 0.2s;"></span>
                                <span class="w-1 h-5 bg-red-400/70 rounded-full animate-pulse" style="animation-delay: 0.3s;"></span>
                                <span class="w-1 h-7 bg-red-400/90 rounded-full animate-pulse" style="animation-delay: 0.4s;"></span>
                                <span class="w-1 h-4 bg-red-400/60 rounded-full animate-pulse" style="animation-delay: 0.5s;"></span>
                                <span class="w-1 h-6 bg-red-400/80 rounded-full animate-pulse" style="animation-delay: 0.6s;"></span>
                            </div>
                        </div>
                    </div>
                    {{-- Floating badges --}}
                    <div class="absolute -top-2 right-8 bg-red-700/80 text-white text-xs px-3 py-1.5 rounded-full shadow-lg backdrop-blur-sm">
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            CA / ES / EN / FR
                        </span>
                    </div>
                    <div class="absolute bottom-4 -left-4 bg-white/10 text-white text-xs px-3 py-1.5 rounded-full shadow-lg backdrop-blur-sm">
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                            QR
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Wave transition --}}
<div class="relative -mt-1">
    <svg class="w-full h-12 md:h-16" viewBox="0 0 1440 64" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0 0L48 5.3C96 10.7 192 21.3 288 26.7C384 32 480 32 576 26.7C672 21.3 768 10.7 864 10.7C960 10.7 1056 21.3 1152 26.7C1248 32 1344 32 1392 32H1440V64H0V0Z" class="fill-gray-900"/>
        <path d="M0 0L48 5.3C96 10.7 192 21.3 288 26.7C384 32 480 32 576 26.7C672 21.3 768 10.7 864 10.7C960 10.7 1056 21.3 1152 26.7C1248 32 1344 32 1392 32H1440V64H0V0Z" fill="white"/>
    </svg>
</div>

{{-- Exhibitions Section --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    @if($exposicions->isEmpty())
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
            <p class="mt-4 text-gray-500">
                @switch($idioma)
                    @case('es') No hay exposiciones disponibles en este momento @break
                    @case('en') No exhibitions available at this time @break
                    @case('fr') Aucune exposition disponible pour le moment @break
                    @default No hi ha exposicions disponibles en aquest moment
                @endswitch
            </p>
        </div>
    @else
        {{-- Section header --}}
        <div class="flex items-center gap-4 mb-8">
            <div class="w-1 h-8 bg-red-700 rounded-full"></div>
            <h2 class="text-2xl lg:text-3xl font-bold text-gray-900">
                @switch($idioma)
                    @case('es') Exposiciones @break
                    @case('en') Exhibitions @break
                    @case('fr') Expositions @break
                    @default Exposicions
                @endswitch
            </h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($exposicions as $exposicio)
                @include('components.exhibit-card', ['exposicio' => $exposicio])
            @endforeach
        </div>
    @endif
</div>
@endsection
