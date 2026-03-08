@extends('layouts.app')

@section('title', $material->titol)

@section('content')
<div class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div>
                    <a
                        href="{{ route('peca.show', ['idioma' => $idioma, 'exposicio' => $peca->exposicio->slug, 'slug' => $peca->slug]) }}"
                        class="inline-flex items-center gap-2 text-gray-600 hover:text-red-700 mb-2"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        @switch($idioma)
                            @case('es') Volver @break
                            @case('en') Back @break
                            @case('fr') Retour @break
                            @default Tornar
                        @endswitch
                    </a>
                    <h1 class="text-xl font-bold text-gray-900">{{ $material->titol }}</h1>
                </div>
                @if($material->tipus === 'pdf')
                    <a
                        href="{{ Storage::disk('public')->url($material->url) }}"
                        download
                        class="inline-flex items-center gap-2 px-4 py-2 bg-red-700 hover:bg-red-800 text-white rounded-lg transition"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        @switch($idioma)
                            @case('es') Descargar @break
                            @case('en') Download @break
                            @case('fr') Telecharger @break
                            @default Descarregar
                        @endswitch
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Content Viewer -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @if($material->tipus === 'pdf')
            <div class="bg-white rounded-xl shadow-lg overflow-hidden" style="height: calc(100vh - 200px);">
                <iframe
                    src="{{ Storage::disk('public')->url($material->url) }}#toolbar=0&navpanes=0"
                    class="w-full h-full"
                    frameborder="0"
                ></iframe>
            </div>
        @elseif($material->tipus === 'video')
            <div class="bg-white rounded-xl shadow-lg overflow-hidden p-4">
                <div class="aspect-video">
                    @if(Str::contains($material->url, 'youtube'))
                        @php
                            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $material->url, $matches);
                            $videoId = $matches[1] ?? null;
                        @endphp
                        @if($videoId)
                            <iframe
                                src="https://www.youtube.com/embed/{{ $videoId }}"
                                class="w-full h-full rounded-lg"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen
                            ></iframe>
                        @endif
                    @elseif(Str::contains($material->url, 'vimeo'))
                        @php
                            preg_match('/vimeo\.com\/(\d+)/', $material->url, $matches);
                            $videoId = $matches[1] ?? null;
                        @endphp
                        @if($videoId)
                            <iframe
                                src="https://player.vimeo.com/video/{{ $videoId }}"
                                class="w-full h-full rounded-lg"
                                frameborder="0"
                                allow="autoplay; fullscreen; picture-in-picture"
                                allowfullscreen
                            ></iframe>
                        @endif
                    @else
                        <video controls class="w-full h-full rounded-lg">
                            <source src="{{ $material->url }}" type="video/mp4">
                        </video>
                    @endif
                </div>
            </div>
        @else
            <!-- External link redirect -->
            <div class="bg-white rounded-xl shadow-lg p-8 text-center">
                <p class="text-gray-600 mb-4">
                    @switch($idioma)
                        @case('es') Redirigiendo al enlace externo... @break
                        @case('en') Redirecting to external link... @break
                        @case('fr') Redirection vers le lien externe... @break
                        @default Redirigint a l'enllac extern...
                    @endswitch
                </p>
                <a href="{{ $material->url }}" target="_blank" class="text-red-700 hover:underline">
                    {{ $material->url }}
                </a>
                <script>
                    setTimeout(function() {
                        window.location.href = '{{ $material->url }}';
                    }, 1500);
                </script>
            </div>
        @endif
    </div>
</div>
@endsection
