@extends('layouts.app')

@section('title', $document->titol)

@section('content')
<div class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div>
                    <a
                        href="javascript:history.back()"
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
                    <h1 class="text-xl font-bold text-gray-900">{{ $document->titol }}</h1>
                    @if($document->descripcio)
                        <p class="text-gray-600 text-sm mt-1">{{ $document->descripcio }}</p>
                    @endif
                </div>
                <a
                    href="{{ Storage::disk('public')->url($document->fitxer) }}"
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
            </div>
        </div>
    </div>

    <!-- PDF Viewer -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden" style="height: calc(100vh - 200px);">
            <iframe
                src="{{ Storage::disk('public')->url($document->fitxer) }}#toolbar=0&navpanes=0"
                class="w-full h-full"
                frameborder="0"
            ></iframe>
        </div>
    </div>
</div>
@endsection
