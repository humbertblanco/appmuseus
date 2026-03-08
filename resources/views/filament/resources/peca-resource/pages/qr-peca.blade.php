<x-filament-panels::page>
    @php
        $idiomesAD = $record->traduccions->filter(fn ($t) => $t->teAudioDescripcioAudio())->pluck('idioma')->toArray();
    @endphp

    <div class="space-y-6">
        <!-- Codis QR normals -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow">
            <h2 class="text-lg font-semibold mb-4">Codis QR per a la peça: {{ $record->traduccio('ca')?->titol ?? $record->slug }}</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach(['ca' => 'Català', 'es' => 'Castellà', 'en' => 'Anglès', 'fr' => 'Francès'] as $code => $name)
                    <div class="flex flex-col items-center p-4 border rounded-lg">
                        <p class="text-sm font-semibold mb-3">{{ $name }}</p>

                        <div class="bg-white p-2 rounded-lg mb-3">
                            {!! $this->getQrSvgForIdioma($code) !!}
                        </div>

                        <p class="text-xs text-gray-500 mb-3 text-center break-all">
                            {{ $this->getQrUrlForIdioma($code) }}
                        </p>

                        <a
                            href="{{ route('peca.qr.download', ['id' => $record->id, 'idioma' => $code]) }}"
                            class="inline-flex items-center gap-2 px-3 py-1.5 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition"
                        >
                            <x-heroicon-o-arrow-down-tray class="w-4 h-4" />
                            SVG
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Codis QR amb Audiodescripció -->
        @if(count($idiomesAD) > 0)
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow">
                <h2 class="text-lg font-semibold mb-4 flex items-center gap-2">
                    <x-heroicon-o-speaker-wave class="w-5 h-5 text-blue-600" />
                    Codis QR Audiodescripció
                </h2>
                <p class="text-sm text-gray-500 mb-4">Aquests QR activen automàticament el mode audiodescripció per a persones cegues.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach(['ca' => 'Català', 'es' => 'Castellà', 'en' => 'Anglès', 'fr' => 'Francès'] as $code => $name)
                        @if(in_array($code, $idiomesAD))
                            <div class="flex flex-col items-center p-4 border border-blue-200 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                <p class="text-sm font-semibold mb-3">AD {{ $name }}</p>

                                <div class="bg-white p-2 rounded-lg mb-3">
                                    {!! $this->getQrSvgForIdiomaAD($code) !!}
                                </div>

                                <p class="text-xs text-gray-500 mb-3 text-center break-all">
                                    {{ $this->getQrUrlForIdiomaAD($code) }}
                                </p>

                                <a
                                    href="{{ route('peca.qr.download', ['id' => $record->id, 'idioma' => $code . '-ad']) }}"
                                    class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition"
                                >
                                    <x-heroicon-o-arrow-down-tray class="w-4 h-4" />
                                    PNG
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow">
            <h3 class="font-semibold mb-4">Instruccions</h3>
            <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-2">
                <li>• Cada codi QR porta directament a la pàgina de la peça en l'idioma corresponent.</li>
                <li>• Els codis QR d'audiodescripció activen automàticament l'àudio per a persones cegues.</li>
                <li>• Fes clic a "PNG" per descarregar el codi QR en format imatge.</li>
                <li>• Els codis QR es poden imprimir per col·locar-los al costat de cada peça.</li>
            </ul>
        </div>
    </div>
</x-filament-panels::page>
