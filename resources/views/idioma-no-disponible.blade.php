@extends('layouts.app')

@section('title', 'Idioma no disponible - Audioguia')

@section('content')
<div class="max-w-lg mx-auto px-4 py-16 text-center">
    <div class="bg-white rounded-xl shadow-sm p-8">
        <svg class="mx-auto h-16 w-16 text-yellow-500 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
        </svg>

        <h1 class="text-2xl font-bold text-gray-900 mb-4">
            @switch($idioma)
                @case('es')
                    Contenido no disponible
                    @break
                @case('en')
                    Content not available
                    @break
                @case('fr')
                    Contenu non disponible
                    @break
                @default
                    Contingut no disponible
            @endswitch
        </h1>

        <p class="text-gray-600 mb-8">
            @switch($idioma)
                @case('es')
                    Este contenido no está disponible en el idioma seleccionado. Por favor, selecciona otro idioma.
                    @break
                @case('en')
                    This content is not available in the selected language. Please select another language.
                    @break
                @case('fr')
                    Ce contenu n'est pas disponible dans la langue sélectionnée. Veuillez sélectionner une autre langue.
                    @break
                @default
                    Aquest contingut no està disponible en l'idioma seleccionat. Si us plau, selecciona un altre idioma.
            @endswitch
        </p>

        <div class="space-y-3">
            <p class="text-sm font-medium text-gray-700 mb-4">
                @switch($idioma)
                    @case('es')
                        Idiomas disponibles:
                        @break
                    @case('en')
                        Available languages:
                        @break
                    @case('fr')
                        Langues disponibles:
                        @break
                    @default
                        Idiomes disponibles:
                @endswitch
            </p>

            @php
                $idiomesNoms = [
                    'ca' => 'Català',
                    'es' => 'Castellà',
                    'en' => 'English',
                    'fr' => 'Français',
                ];
            @endphp

            @foreach($idiomesDisponibles as $codi)
                <a
                    href="{{ $tipus === 'exposicio' ? route('exposicio.show', ['idioma' => $codi, 'slug' => $slug]) : route('peca.show', ['idioma' => $codi, 'exposicio' => $exposicioSlug, 'slug' => $slug]) }}"
                    class="block w-full py-3 px-4 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition font-medium"
                >
                    {{ $idiomesNoms[$codi] ?? $codi }}
                </a>
            @endforeach
        </div>

        <div class="mt-8 pt-6 border-t">
            <a href="{{ route('home') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                @switch($idioma)
                    @case('es')
                        Volver al inicio
                        @break
                    @case('en')
                        Back to home
                        @break
                    @case('fr')
                        Retour à l'accueil
                        @break
                    @default
                        Tornar a l'inici
                @endswitch
            </a>
        </div>
    </div>
</div>
@endsection
