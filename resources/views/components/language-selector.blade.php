@php
    $idiomes = [
        'ca' => ['nom' => 'Català', 'curt' => 'CA'],
        'es' => ['nom' => 'Español', 'curt' => 'ES'],
        'en' => ['nom' => 'English', 'curt' => 'EN'],
        'fr' => ['nom' => 'Français', 'curt' => 'FR'],
    ];
    $currentIdioma = $idioma ?? 'ca';
    $disponibles = $idiomesDisponibles ?? array_keys($idiomes);
    // Mode AD es detecta via query param o cookie
    $modeAD = request()->has('ad') || request()->cookie('audiodescripcio') == '1';

    // Idiomes amb audiodescripcio disponible (es passa des del controlador)
    $idiomesAD = $idiomesAmbAudiodescripcio ?? [];
@endphp

<div x-data="{ open: false }" class="relative" @click.away="open = false">
    <button
        @click="open = !open"
        type="button"
        class="flex items-center gap-2 px-3 py-2 text-red-700 hover:text-red-800 hover:bg-red-50 rounded-lg transition"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
        </svg>
        <span class="font-medium">
            @if($modeAD)
                AD {{ $idiomes[$currentIdioma]['curt'] ?? 'CA' }}
            @else
                {{ $idiomes[$currentIdioma]['curt'] ?? 'CA' }}
            @endif
        </span>
        <svg class="w-4 h-4" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded-lg shadow-xl overflow-hidden z-50"
    >
        <!-- Idiomes normals -->
        <div class="py-1">
            <div class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider bg-gray-50">
                @switch($currentIdioma)
                    @case('es') Idiomas @break
                    @case('en') Languages @break
                    @case('fr') Langues @break
                    @default Idiomes
                @endswitch
            </div>
            @foreach($idiomes as $code => $info)
                @if(in_array($code, $disponibles))
                    @php
                        $routeName = request()->route()?->getName();
                        $currentSlug = $slug ?? request()->route('slug');
                        $expSlug = $exposicioSlug ?? request()->route('exposicio');

                        if ($routeName === 'exposicio.show' && $currentSlug) {
                            $url = route('exposicio.show', ['idioma' => $code, 'slug' => $currentSlug]);
                        } elseif ($routeName === 'peca.show' && $currentSlug && $expSlug) {
                            $url = route('peca.show', ['idioma' => $code, 'exposicio' => $expSlug, 'slug' => $currentSlug]);
                        } else {
                            $url = route('home.idioma', ['idioma' => $code]);
                        }
                    @endphp
                    <a
                        href="{{ $url }}"
                        class="block w-full px-4 py-2.5 text-left text-sm transition-colors {{ ($code === $currentIdioma && !$modeAD) ? 'bg-red-700 text-white font-semibold' : 'text-gray-700 hover:bg-red-50' }}"
                    >
                        {{ $info['nom'] }}
                    </a>
                @else
                    <span class="block px-4 py-2.5 text-sm text-gray-400 cursor-not-allowed">
                        {{ $info['nom'] }} (no disponible)
                    </span>
                @endif
            @endforeach
        </div>

        <!-- Audiodescripcio -->
        @if(count($idiomesAD) > 0)
            <div class="py-1 border-t border-gray-200">
                <div class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider bg-gray-50 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path>
                    </svg>
                    @switch($currentIdioma)
                        @case('es') Audiodescripcion @break
                        @case('en') Audio description @break
                        @case('fr') Audiodescription @break
                        @default Audiodescripció
                    @endswitch
                </div>
                @foreach($idiomes as $code => $info)
                    @if(in_array($code, $idiomesAD))
                        @php
                            $routeName = request()->route()?->getName();
                            $currentSlug = $slug ?? request()->route('slug');
                            $expSlug = $exposicioSlug ?? request()->route('exposicio');

                            if ($routeName === 'exposicio.show' && $currentSlug) {
                                $adUrl = route('exposicio.show', ['idioma' => $code, 'slug' => $currentSlug]) . '?ad=1';
                            } elseif ($routeName === 'peca.show' && $currentSlug && $expSlug) {
                                $adUrl = route('peca.show', ['idioma' => $code, 'exposicio' => $expSlug, 'slug' => $currentSlug]) . '?ad=1';
                            } else {
                                $adUrl = route('home.idioma', ['idioma' => $code]);
                            }
                        @endphp
                        <a
                            href="{{ $adUrl }}"
                            class="block w-full px-4 py-2.5 text-left text-sm transition-colors {{ ($code === $currentIdioma && $modeAD) ? 'bg-red-700 text-white font-semibold' : 'text-gray-700 hover:bg-red-50' }}"
                        >
                            AD {{ $info['nom'] }}
                        </a>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</div>
