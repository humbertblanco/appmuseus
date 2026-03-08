<div
    x-data="{
        open: false,
        fontSize: localStorage.getItem('a11y-fontSize') || 'normal',
        contrast: localStorage.getItem('a11y-contrast') || 'normal',

        init() {
            this.applySettings();
        },

        applySettings() {
            // Font size
            document.documentElement.classList.remove('text-sm', 'text-base', 'text-lg', 'text-xl');
            if (this.fontSize === 'large') {
                document.documentElement.style.fontSize = '18px';
            } else if (this.fontSize === 'xlarge') {
                document.documentElement.style.fontSize = '22px';
            } else {
                document.documentElement.style.fontSize = '16px';
            }

            // Contrast
            document.documentElement.classList.remove('high-contrast');
            if (this.contrast === 'high') {
                document.documentElement.classList.add('high-contrast');
            }
        },

        setFontSize(size) {
            this.fontSize = size;
            localStorage.setItem('a11y-fontSize', size);
            this.applySettings();
        },

        setContrast(mode) {
            this.contrast = mode;
            localStorage.setItem('a11y-contrast', mode);
            this.applySettings();
        },

        reset() {
            this.fontSize = 'normal';
            this.contrast = 'normal';
            localStorage.removeItem('a11y-fontSize');
            localStorage.removeItem('a11y-contrast');
            this.applySettings();
        }
    }"
    x-init="init()"
    class="fixed bottom-20 right-4 z-50 lg:bottom-4"
>
    <!-- Toggle button -->
    <button
        @click="open = !open"
        class="size-12 bg-blue-600 hover:bg-blue-700 text-white rounded-full shadow-lg flex items-center justify-center transition-colors"
        :aria-expanded="open"
        aria-label="@switch($idioma ?? 'ca')@case('es')Opciones de accesibilidad@break @case('en')Accessibility options@break @case('fr')Options d'accessibilite@break @default Opcions d'accessibilitat @endswitch"
    >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
        </svg>
    </button>

    <!-- Panel -->
    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4"
        @click.away="open = false"
        class="absolute bottom-16 right-0 w-72 bg-white rounded-xl shadow-2xl border border-gray-200 overflow-hidden"
    >
        <div class="bg-blue-600 text-white px-4 py-3">
            <h3 class="font-semibold">
                @switch($idioma ?? 'ca')
                    @case('es') Accesibilidad @break
                    @case('en') Accessibility @break
                    @case('fr') Accessibilite @break
                    @default Accessibilitat
                @endswitch
            </h3>
        </div>

        <div class="p-4 space-y-4">
            <!-- Font size -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    @switch($idioma ?? 'ca')
                        @case('es') Tamano de letra @break
                        @case('en') Font size @break
                        @case('fr') Taille du texte @break
                        @default Mida del text
                    @endswitch
                </label>
                <div class="flex gap-2">
                    <button
                        @click="setFontSize('normal')"
                        :class="fontSize === 'normal' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        class="flex-1 py-2 px-3 rounded-lg text-sm font-medium transition-colors"
                    >
                        A
                    </button>
                    <button
                        @click="setFontSize('large')"
                        :class="fontSize === 'large' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        class="flex-1 py-2 px-3 rounded-lg text-base font-medium transition-colors"
                    >
                        A+
                    </button>
                    <button
                        @click="setFontSize('xlarge')"
                        :class="fontSize === 'xlarge' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        class="flex-1 py-2 px-3 rounded-lg text-lg font-medium transition-colors"
                    >
                        A++
                    </button>
                </div>
            </div>

            <!-- Contrast -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    @switch($idioma ?? 'ca')
                        @case('es') Contraste @break
                        @case('en') Contrast @break
                        @case('fr') Contraste @break
                        @default Contrast
                    @endswitch
                </label>
                <div class="flex gap-2">
                    <button
                        @click="setContrast('normal')"
                        :class="contrast === 'normal' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        class="flex-1 py-2 px-3 rounded-lg text-sm font-medium transition-colors"
                    >
                        @switch($idioma ?? 'ca')
                            @case('es') Normal @break
                            @case('en') Normal @break
                            @case('fr') Normal @break
                            @default Normal
                        @endswitch
                    </button>
                    <button
                        @click="setContrast('high')"
                        :class="contrast === 'high' ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        class="flex-1 py-2 px-3 rounded-lg text-sm font-medium transition-colors"
                    >
                        @switch($idioma ?? 'ca')
                            @case('es') Alto @break
                            @case('en') High @break
                            @case('fr') Eleve @break
                            @default Alt
                        @endswitch
                    </button>
                </div>
            </div>

            <!-- Reset -->
            <button
                @click="reset()"
                class="w-full py-2 px-4 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition-colors"
            >
                @switch($idioma ?? 'ca')
                    @case('es') Restablecer @break
                    @case('en') Reset @break
                    @case('fr') Reinitialiser @break
                    @default Restablir
                @endswitch
            </button>
        </div>
    </div>
</div>
