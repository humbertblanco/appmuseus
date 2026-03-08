<footer class="bg-gray-800 text-white py-8 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <p class="font-semibold text-sm">{{ config('museum.institution', config('museum.name', 'Museum Audioguide')) }}</p>
                @if(config('museum.footer_credit'))
                    <p class="text-gray-400 text-xs mt-1">{{ config('museum.footer_credit') }}</p>
                @endif
            </div>
            <div class="text-sm text-gray-400">
                @switch($idioma ?? config('museum.default_locale', 'ca'))
                    @case('es') Audioguia digital @break
                    @case('en') Digital audioguide @break
                    @case('fr') Audioguide numerique @break
                    @default Audioguia digital
                @endswitch
            </div>
        </div>
        <div class="border-t border-gray-700 pt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <p class="text-gray-500 text-xs">
                &copy; {{ date('Y') }} {{ config('museum.institution', config('museum.name', 'Museum Audioguide')) }}
            </p>
            <div class="flex items-center gap-4">
                <a href="https://creativecommons.org/licenses/by-nc-nd/4.0/deed.ca" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 text-gray-500 hover:text-gray-300 transition-colors text-xs">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm0 1.5c5.799 0 10.5 4.701 10.5 10.5S17.799 22.5 12 22.5 1.5 17.799 1.5 12 6.201 1.5 12 1.5zm-1.8 6.9c-1.986 0-3.6 1.614-3.6 3.6s1.614 3.6 3.6 3.6c1.193 0 2.25-.581 2.905-1.476l-1.442-.834c-.36.467-.924.768-1.556.768a2.065 2.065 0 01-2.057-2.058c0-1.135.922-2.058 2.057-2.058.632 0 1.196.301 1.556.768l1.442-.834A3.594 3.594 0 0010.2 8.4zm6.6 0c-1.986 0-3.6 1.614-3.6 3.6s1.614 3.6 3.6 3.6c1.193 0 2.25-.581 2.905-1.476l-1.442-.834c-.36.467-.924.768-1.556.768a2.065 2.065 0 01-2.057-2.058c0-1.135.922-2.058 2.057-2.058.632 0 1.196.301 1.556.768l1.442-.834A3.594 3.594 0 0016.8 8.4z"/></svg>
                    CC BY-NC-ND 4.0
                </a>
                @if(config('museum.legal_url'))
                    <a href="{{ config('museum.legal_url') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 text-gray-500 hover:text-gray-300 transition-colors text-xs">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        @switch($idioma ?? config('museum.default_locale', 'ca'))
                            @case('es') Aviso Legal @break
                            @case('en') Legal Notice @break
                            @case('fr') Mentions legales @break
                            @default Avis Legal
                        @endswitch
                    </a>
                @endif
            </div>
        </div>
    </div>
</footer>
