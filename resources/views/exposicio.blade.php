@extends('layouts.app')

@section('title', $traduccio->titol . ' - Audioguia')

@php
    $slug = $exposicio->slug;
    $idiomesDisponibles = $exposicio->idiomesDisponibles();
    $insideExpo = true;
@endphp

@section('content')
<div class="bg-white min-h-screen">
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header exposition - Two column layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            <!-- Image -->
            <div class="rounded-xl overflow-hidden">
                @if($exposicio->imatge_portada)
                    <img
                        src="{{ Storage::disk('public')->url($exposicio->imatge_portada) }}"
                        alt="{{ $traduccio->titol }}"
                        class="w-full h-full object-cover aspect-[4/3]"
                    >
                @else
                    <div class="w-full aspect-[4/3] bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                        <svg class="w-24 h-24 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                @endif
            </div>

            <!-- Info -->
            <div class="flex flex-col justify-center">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $traduccio->titol }}</h1>

                @if($traduccio->descripcio)
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        {{ Str::limit(strip_tags($traduccio->descripcio), 200) }}
                    </p>
                @endif

                <!-- Contact information -->
                <div class="space-y-3 text-sm">
                    @if($traduccio->adreca)
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-gray-600">{{ $traduccio->adreca }}</span>
                        </div>
                    @endif

                    @if($traduccio->telefon)
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <a href="tel:{{ $traduccio->telefon }}" class="text-gray-600 hover:text-primary-700">{{ $traduccio->telefon }}</a>
                        </div>
                    @endif

                    @if($traduccio->email)
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <a href="mailto:{{ $traduccio->email }}" class="text-gray-600 hover:text-primary-700">{{ $traduccio->email }}</a>
                        </div>
                    @endif

                    @if($traduccio->web_url)
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                            </svg>
                            <a href="{{ $traduccio->web_url }}" target="_blank" class="text-gray-600 hover:text-primary-700">Web del museu</a>
                        </div>
                    @endif

                    @if($traduccio->facebook_url || $traduccio->instagram_url)
                        <div class="flex items-center gap-4 pt-1">
                            @if($traduccio->facebook_url)
                                <a href="{{ $traduccio->facebook_url }}" target="_blank" class="flex items-center gap-2 text-gray-500 hover:text-blue-600 transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                    <span class="text-sm">Facebook</span>
                                </a>
                            @endif
                            @if($traduccio->instagram_url)
                                <a href="{{ $traduccio->instagram_url }}" target="_blank" class="flex items-center gap-2 text-gray-500 hover:text-pink-600 transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                                    <span class="text-sm">Instagram</span>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Pieces -->
        <div class="flex items-center justify-between mb-6">
            <div class="text-gray-900">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zM12 2.25V4.5m5.834.166l-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243l-1.59-1.59"></path>
                </svg>
            </div>

            @if(request()->has('ad'))
            <div class="flex items-center gap-2 px-3 py-1.5 bg-primary-100 text-primary-700 rounded-full text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path>
                </svg>
                @switch($idioma)
                    @case('es') Modo audiodescripción @break
                    @case('en') Audio description mode @break
                    @case('fr') Mode audiodescription @break
                    @default Mode audiodescripció
                @endswitch
            </div>
            @endif
        </div>

        @php
            $modeAD = request()->has('ad');
            // En mode AD, filtrar només les peces que tenen audiodescripció en l'idioma actual
            $pecesAMostrar = $modeAD
                ? $peces->filter(fn ($p) => $p->traduccions->contains(fn ($t) => $t->idioma === $idioma && !empty($t->audio_descripcio_url)))
                : $peces;
        @endphp

        @if($pecesAMostrar->isEmpty())
            <div class="bg-gray-50 rounded-xl p-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <p class="mt-4 text-gray-500">
                    @if($modeAD)
                        @switch($idioma)
                            @case('es') No hay piezas con audiodescripción disponibles @break
                            @case('en') No pieces with audio description available @break
                            @case('fr') Aucune piece avec audiodescription disponible @break
                            @default No hi ha peces amb audiodescripció disponibles
                        @endswitch
                    @else
                        @switch($idioma)
                            @case('es') No hay piezas disponibles en este idioma @break
                            @case('en') No pieces available in this language @break
                            @case('fr') Aucune piece disponible dans cette langue @break
                            @default No hi ha peces disponibles en aquest idioma
                        @endswitch
                    @endif
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($pecesAMostrar as $peca)
                    @php
                        $pecaTraduccio = $peca->traduccio($idioma);
                        $primeraImatge = $peca->imatges->first();
                        // Audiodescripció (per a persones cegues) - té àudio AD en l'idioma actual
                        $teAudioAD = $peca->traduccions->contains(fn ($t) => $t->idioma === $idioma && !empty($t->audio_descripcio_url));
                        // Transcripció (per a persones sordes) - té text transcripció en l'idioma actual
                        $teTranscripcio = $peca->traduccions->contains(fn ($t) => $t->idioma === $idioma && !empty($t->text_audiodescripcio));
                        $pecaUrl = route('peca.show', ['idioma' => $idioma, 'exposicio' => $exposicio->slug, 'slug' => $peca->slug]);
                        if ($modeAD) {
                            $pecaUrl .= '?ad=1';
                        }
                    @endphp
                    <a
                        href="{{ $pecaUrl }}"
                        class="group block"
                    >
                        <div class="relative">
                            <div class="aspect-[4/3] bg-gray-200 rounded-xl overflow-hidden relative">
                                @if($primeraImatge)
                                    <img
                                        src="{{ Storage::disk('public')->url($primeraImatge->url) }}"
                                        alt="{{ $pecaTraduccio->titol ?? $peca->slug }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                    >
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif

                                <!-- Accessibility badges (bottom-right, inside image) -->
                                @if($teAudioAD || $teTranscripcio)
                                <div class="absolute bottom-2 right-2 z-10 flex gap-1">
                                    @if($teAudioAD)
                                    {{-- Audiodescripció per a persones cegues --}}
                                    <div class="bg-primary-700 text-white p-1.5 rounded-full shadow-md" title="Audiodescripció (persones cegues)">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path>
                                        </svg>
                                    </div>
                                    @endif
                                    @if($teTranscripcio)
                                    {{-- Transcripció per a persones sordes --}}
                                    <div class="bg-primary-700 text-white p-1.5 rounded-full shadow-md" title="Transcripció (persones sordes)">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="mt-3">
                            <h3 class="text-2xl font-semibold text-gray-900 group-hover:text-primary-700 transition-colors">
                                {{ $pecaTraduccio->titol ?? $peca->slug }}
                            </h3>
                            @if($pecaTraduccio && $pecaTraduccio->subtitol)
                                <p class="text-base text-gray-500 mt-0.5">{{ $pecaTraduccio->subtitol }}</p>
                            @endif
                            @if($pecaTraduccio && $pecaTraduccio->periode)
                                <p class="text-sm text-gray-400 mt-0.5">{{ $pecaTraduccio->periode }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        <!-- Documents / Fulls de sala -->
        @if($documents->isNotEmpty())
            <div class="mt-12 pt-8 border-t border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">
                    @switch($idioma)
                        @case('es') Documentos @break
                        @case('en') Documents @break
                        @case('fr') Documents @break
                        @default Documents
                    @endswitch
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($documents as $document)
                        <a
                            href="{{ route('document.show', $document->id) }}"
                            class="flex items-center gap-4 p-4 bg-white rounded-xl border border-gray-200 hover:border-primary-300 hover:shadow-md transition group"
                        >
                            <div class="flex-shrink-0 w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-primary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-medium text-gray-900 group-hover:text-primary-700 transition truncate">
                                    {{ $document->titol }}
                                </h3>
                                @if($document->descripcio)
                                    <p class="text-sm text-gray-500 truncate">{{ $document->descripcio }}</p>
                                @endif
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-primary-700 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </main>
</div>
@endsection
