@extends('layouts.app')

@section('title', $traduccio->titol . ' - Audioguia')

@php
    $slug = $peca->slug;
    $idiomesDisponibles = $peca->idiomesDisponibles();
    $exposicioTraduccio = $peca->exposicio->traduccio($idioma);
    $insideExpo = true;

    // Get previous and next pieces for navigation
    $allPeces = $peca->exposicio->peces()->where('activa', true)->orderBy('ordre')->get();
    $currentIndex = $allPeces->search(fn($p) => $p->id === $peca->id);
    $prevPeca = $currentIndex > 0 ? $allPeces[$currentIndex - 1] : null;
    $nextPeca = $currentIndex < $allPeces->count() - 1 ? $allPeces[$currentIndex + 1] : null;

    // Mantenir el mode AD a la navegació
    $adParam = $modeAudiodescripcio ? '?ad=1' : '';
@endphp

@section('content')
<div class="bg-white min-h-screen relative">
    <!-- Navigation arrows (fixed on sides) -->
    @if($prevPeca)
        <a
            href="{{ route('peca.show', ['idioma' => $idioma, 'exposicio' => $peca->exposicio->slug, 'slug' => $prevPeca->slug]) }}{{ $adParam }}"
            class="fixed left-4 top-1/2 -translate-y-1/2 z-30 size-12 bg-white rounded-full shadow-lg flex items-center justify-center text-gray-700 hover:text-white hover:bg-red-700 transition-colors hidden lg:flex"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>
    @endif

    @if($nextPeca)
        <a
            href="{{ route('peca.show', ['idioma' => $idioma, 'exposicio' => $peca->exposicio->slug, 'slug' => $nextPeca->slug]) }}{{ $adParam }}"
            class="fixed right-4 top-1/2 -translate-y-1/2 z-30 size-12 bg-white rounded-full shadow-lg flex items-center justify-center text-gray-700 hover:text-white hover:bg-red-700 transition-colors hidden lg:flex"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
    @endif

    <!-- Back button -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-4 border-b border-gray-100">
        <a
            href="{{ route('exposicio.show', ['idioma' => $idioma, 'slug' => $peca->exposicio->slug]) }}{{ $adParam }}"
            class="inline-flex items-center gap-2 text-gray-700 hover:text-red-700 transition-colors"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            @switch($idioma)
                @case('es') Volver a la galeria @break
                @case('en') Back to gallery @break
                @case('fr') Retour a la galerie @break
                @default Tornar a la galeria
            @endswitch
        </a>
    </div>

    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Main image with stop number -->
        <div class="relative mb-6">
            @if($peca->imatges->isNotEmpty())
                <div x-data="{ activeImage: 0 }" class="relative rounded-xl overflow-hidden">
                    @foreach($peca->imatges as $index => $imatge)
                        <img
                            x-show="activeImage === {{ $index }}"
                            src="{{ Storage::disk('public')->url($imatge->url) }}"
                            alt="{{ $imatge->alt_text ?? $traduccio->titol }}"
                            class="w-full aspect-square md:aspect-[16/9] object-cover"
                        >
                    @endforeach

                    @if($peca->imatges->count() > 1)
                        <button
                            @click="activeImage = (activeImage - 1 + {{ $peca->imatges->count() }}) % {{ $peca->imatges->count() }}"
                            class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/90 backdrop-blur-sm rounded-full p-2 shadow-lg hover:bg-white transition"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <button
                            @click="activeImage = (activeImage + 1) % {{ $peca->imatges->count() }}"
                            class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/90 backdrop-blur-sm rounded-full p-2 shadow-lg hover:bg-white transition"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    @endif
                </div>
            @else
                <div class="w-full aspect-square md:aspect-[16/9] bg-gray-100 rounded-xl flex items-center justify-center">
                    <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            @endif
        </div>

        <!-- Title and metadata -->
        <div class="mb-4">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ $traduccio->titol }}</h1>
            @if($traduccio->subtitol)
                <p class="text-lg text-gray-600 mt-1">{{ $traduccio->subtitol }}</p>
            @endif
            @if($traduccio->periode)
                <p class="text-sm text-gray-400 mt-1">{{ $traduccio->periode }}</p>
            @endif
        </div>

        <!-- Audio player section (above description on mobile for quick access) -->
        @php
            $teADaquestIdioma = !empty($traduccio->audio_descripcio_url);
            $reproduintAD = $modeAudiodescripcio && $teADaquestIdioma;
            $audioUrl = $reproduintAD
                ? $traduccio->audio_descripcio_url
                : $traduccio->audio_url;

            $nomIdiomes = [
                'ca' => 'Català',
                'es' => 'Español',
                'en' => 'English',
                'fr' => 'Français',
            ];
        @endphp

        @if($audioUrl)
            <div class="py-4 mb-4 border-t border-b border-gray-100">
                <div class="text-center mb-2">
                    <h2 class="text-base font-medium text-gray-900">
                        @if($reproduintAD)
                            <span class="inline-flex items-center gap-2">
                                <svg class="w-5 h-5 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path>
                                </svg>
                                @switch($idioma)
                                    @case('es') Audiodescripcion @break
                                    @case('en') Audio description @break
                                    @case('fr') Audiodescription @break
                                    @default Audiodescripció
                                @endswitch
                            </span>
                        @else
                            @switch($idioma)
                                @case('es') Audio @break
                                @case('en') Audio @break
                                @case('fr') Audio @break
                                @default Àudio
                            @endswitch
                        @endif
                    </h2>
                    <p class="text-xs text-gray-500 mt-1">{{ $nomIdiomes[$idioma] ?? $idioma }}</p>

                    @if($modeAudiodescripcio && !$teADaquestIdioma)
                        <p class="text-xs text-amber-600 mt-1">
                            @switch($idioma)
                                @case('es') Audiodescripcion no disponible en este idioma @break
                                @case('en') Audio description not available in this language @break
                                @case('fr') Audiodescription non disponible dans cette langue @break
                                @default Audiodescripció no disponible en aquest idioma
                            @endswitch
                        </p>
                    @endif
                </div>

                @include('components.audio-player', ['audioUrl' => $audioUrl, 'idioma' => $idioma])
            </div>
        @endif

        <!-- Description text -->
        @if($traduccio->descripcio)
            <div class="prose max-w-none mb-8 text-gray-700 leading-relaxed">
                {!! nl2br(e($traduccio->descripcio)) !!}
            </div>
        @endif

        <!-- Mirada Tàctil: vídeos en llengua de signes catalana (LSC) -->
        @php
            $videoSignesUrl = $videoSignes?->url;
            // Extreure YouTube ID de la URL
            $videoId = null;
            if ($videoSignesUrl && preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/))([a-zA-Z0-9_-]{11})/', $videoSignesUrl, $m)) {
                $videoId = $m[1];
            }
        @endphp

        @if($videoId)
            <div x-data="{ showVideo: false }" class="mt-6">
                <button
                    @click="showVideo = !showVideo"
                    class="flex items-center gap-2 text-sm font-medium text-gray-700 hover:text-red-700 transition-colors"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"></path>
                    </svg>
                    @php
                        $textMostrar = match($idioma) {
                            'es' => 'Mirada Táctil – Vídeo en lengua de signos',
                            'en' => 'Mirada Tàctil – Sign language video',
                            'fr' => 'Mirada Tàctil – Vidéo en langue des signes',
                            default => 'Mirada Tàctil – Vídeo en llengua de signes'
                        };
                        $textAmagar = match($idioma) {
                            'es' => 'Ocultar vídeo',
                            'en' => 'Hide video',
                            'fr' => 'Masquer vidéo',
                            default => 'Amagar vídeo'
                        };
                    @endphp
                    <span x-text="showVideo ? '{{ $textAmagar }}' : '{{ $textMostrar }}'">{{ $textMostrar }}</span>
                    <svg class="w-4 h-4 transition-transform" :class="showVideo ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div
                    x-show="showVideo"
                    x-cloak
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="mt-4 rounded-lg overflow-hidden border border-gray-200"
                >
                    <template x-if="showVideo">
                        <iframe
                            src="https://www.youtube.com/embed/{{ $videoId }}?cc_load_policy=1"
                            class="w-full aspect-video"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                        ></iframe>
                    </template>
                    <div class="px-4 py-2 bg-gray-50 text-xs text-gray-500">
                        @switch($idioma)
                            @case('es') Vídeo en lengua de signos catalana (LSC) con subtítulos @break
                            @case('en') Video in Catalan Sign Language (LSC) with subtitles @break
                            @case('fr') Vidéo en langue des signes catalane (LSC) avec sous-titres @break
                            @default Vídeo en llengua de signes catalana (LSC) amb subtítols
                        @endswitch
                    </div>
                </div>
            </div>
        @endif

        <!-- Additional materials -->
        @if($materials->isNotEmpty())
            <div class="mt-8 pt-6 border-t border-gray-100">
                <h3 class="font-semibold text-gray-900 mb-4">
                    @switch($idioma)
                        @case('es') Materiales adicionales @break
                        @case('en') Additional materials @break
                        @case('fr') Documents supplementaires @break
                        @default Materials addicionals
                    @endswitch
                </h3>
                <div class="space-y-2">
                    @foreach($materials as $material)
                        @php
                            // PDFs i videos s'obren al viewer, enllacos externs s'obren directament
                            $usarViewer = in_array($material->tipus, ['pdf', 'video']);
                            $href = $usarViewer
                                ? route('material.show', $material->id)
                                : $material->url;
                        @endphp
                        <a
                            href="{{ $href }}"
                            {{ $usarViewer ? '' : 'target="_blank"' }}
                            class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition"
                        >
                            @if($material->tipus === 'pdf')
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                            @elseif($material->tipus === 'video')
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            @else
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                            @endif
                            <span class="text-gray-700 hover:text-red-700">{{ $material->titol }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </main>

    <!-- Bottom navigation bar (mobile only, sticky so it doesn't cover footer) -->
    @if($prevPeca || $nextPeca)
    <div class="sticky bottom-0 z-40 bg-white border-t border-gray-200 shadow-[0_-2px_10px_rgba(0,0,0,0.1)] lg:hidden">
        <div class="flex items-stretch divide-x divide-gray-200">
            @if($prevPeca)
                <a
                    href="{{ route('peca.show', ['idioma' => $idioma, 'exposicio' => $peca->exposicio->slug, 'slug' => $prevPeca->slug]) }}{{ $adParam }}"
                    class="flex-1 flex items-center gap-2 py-3 px-4 text-gray-600 active:bg-gray-50 transition-colors min-w-0"
                >
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    <div class="min-w-0">
                        <div class="text-xs text-gray-400">
                            @switch($idioma)
                                @case('es') Anterior @break
                                @case('en') Previous @break
                                @case('fr') Précédent @break
                                @default Anterior
                            @endswitch
                        </div>
                        <div class="text-sm truncate">{{ $prevPeca->traduccio($idioma)?->titol ?? $prevPeca->slug }}</div>
                    </div>
                </a>
            @else
                <div class="flex-1"></div>
            @endif

            @if($nextPeca)
                <a
                    href="{{ route('peca.show', ['idioma' => $idioma, 'exposicio' => $peca->exposicio->slug, 'slug' => $nextPeca->slug]) }}{{ $adParam }}"
                    class="flex-1 flex items-center justify-end gap-2 py-3 px-4 text-gray-900 active:bg-gray-50 transition-colors min-w-0"
                >
                    <div class="min-w-0 text-right">
                        <div class="text-xs text-gray-400">
                            @switch($idioma)
                                @case('es') Siguiente @break
                                @case('en') Next @break
                                @case('fr') Suivant @break
                                @default Següent
                            @endswitch
                        </div>
                        <div class="text-sm font-medium truncate">{{ $nextPeca->traduccio($idioma)?->titol ?? $nextPeca->slug }}</div>
                    </div>
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            @else
                <div class="flex-1"></div>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection
