@php
    $traduccio = $exposicio->traduccio($idioma);
    // Audiodescripció (per a persones cegues) - té àudio AD en l'idioma actual
    $teAudioAD = $exposicio->peces->contains(fn ($p) => $p->traduccions->contains(fn ($t) => $t->idioma === $idioma && !empty($t->audio_descripcio_url)));
    // Transcripció (per a persones sordes) - té text transcripció en l'idioma actual
    $teTranscripcio = $exposicio->peces->contains(fn ($p) => $p->traduccions->contains(fn ($t) => $t->idioma === $idioma && !empty($t->text_audiodescripcio)));
@endphp

<a
    href="{{ route('exposicio.show', ['idioma' => $idioma, 'slug' => $exposicio->slug]) }}"
    class="group block bg-white rounded-xl shadow-sm hover:shadow-lg hover:ring-2 hover:ring-red-700 transition-all duration-300 overflow-hidden"
>
    <div class="aspect-video bg-gray-200 relative overflow-hidden">
        @if($exposicio->imatge_portada)
            <img
                src="{{ Storage::disk('public')->url($exposicio->imatge_portada) }}"
                alt="{{ $traduccio->titol ?? $exposicio->slug }}"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
            >
        @else
            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-red-100 to-red-200">
                <svg class="w-16 h-16 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        @endif

        {{-- Accessibility badges (bottom-right) --}}
        @if($teAudioAD || $teTranscripcio)
            <div class="absolute bottom-3 right-3 flex gap-1.5">
                @if($teAudioAD)
                {{-- Audiodescripció per a persones cegues --}}
                <div class="bg-red-700 text-white px-2 py-1 rounded-full flex items-center gap-1 text-xs font-medium shadow-lg" title="Audiodescripció (persones cegues)">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path>
                    </svg>
                    <span>AD</span>
                </div>
                @endif
                @if($teTranscripcio)
                {{-- Transcripció per a persones sordes --}}
                <div class="bg-red-700 text-white px-2 py-1 rounded-full flex items-center gap-1 text-xs font-medium shadow-lg" title="Transcripció (persones sordes)">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>TXT</span>
                </div>
                @endif
            </div>
        @endif
    </div>

    <div class="p-5 lg:p-6">
        <h2 class="text-lg lg:text-xl font-semibold text-gray-900 group-hover:text-red-700 transition-colors">
            {{ $traduccio->titol ?? $exposicio->slug }}
        </h2>

        @if($traduccio && $traduccio->descripcio)
            <p class="mt-2 text-sm lg:text-base text-gray-600 line-clamp-2 lg:line-clamp-3">
                {{ Str::limit(strip_tags($traduccio->descripcio), 150) }}
            </p>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <div class="flex items-center text-sm text-red-700 font-medium">
                <span>
                    @switch($idioma)
                        @case('es') Ver exposicion @break
                        @case('en') View exhibition @break
                        @case('fr') Voir l'exposition @break
                        @default Veure exposicio
                    @endswitch
                </span>
                <svg class="ml-1 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
            @php $numPeces = $exposicio->peces->filter(fn($p) => $p->activa)->count(); @endphp
            @if($numPeces > 0)
                <span class="text-xs text-gray-400 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ $numPeces }}
                    @switch($idioma)
                        @case('es') espacios @break
                        @case('en') spaces @break
                        @case('fr') espaces @break
                        @default espais
                    @endswitch
                </span>
            @endif
        </div>
    </div>
</a>
