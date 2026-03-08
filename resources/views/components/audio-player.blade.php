@php
    $baseUrl = Str::startsWith($audioUrl, "http") ? $audioUrl : Storage::disk('public')->url($audioUrl);
    // Afegir paràmetre anti-cache per evitar que el navegador serveixi àudio antic
    $audioSrcUrl = $baseUrl . (Str::contains($baseUrl, '?') ? '&' : '?') . 'v=' . ($idioma ?? 'ca');
@endphp

<div
    x-data="{
        playing: false,
        currentTime: 0,
        duration: 0,
        progress: 0,
        volume: 75,
        muted: false,
        error: null,
        audioSrc: @js($audioSrcUrl),

        init() {
            this.$nextTick(() => {
                if (this.$refs.audio) {
                    this.$refs.audio.volume = this.volume / 100;
                    this.$refs.audio.play().then(() => {
                        this.playing = true;
                    }).catch(() => {});
                }
            });
        },

        togglePlay() {
            if (!this.$refs.audio) return;

            if (this.playing) {
                this.$refs.audio.pause();
            } else {
                this.error = null;
                this.$refs.audio.play().catch(e => {
                    this.error = 'Error al reproduir audio';
                    console.error('Audio play error:', e);
                });
            }
            this.playing = !this.playing;
        },

        updateProgress() {
            if (!this.$refs.audio) return;
            this.currentTime = this.$refs.audio.currentTime;
            this.progress = this.duration > 0 ? (this.currentTime / this.duration) * 100 : 0;
        },

        isDragging: false,

        seek(event) {
            if (!this.$refs.audio || !this.duration) return;
            const rect = this.$refs.progressBar.getBoundingClientRect();
            const x = (event.clientX || event.touches?.[0]?.clientX) - rect.left;
            const width = rect.width;
            const percent = Math.max(0, Math.min(1, x / width));
            this.$refs.audio.currentTime = percent * this.duration;
            this.updateProgress();
        },

        startDrag(event) {
            this.isDragging = true;
            this.seek(event);
        },

        onDrag(event) {
            if (!this.isDragging) return;
            this.seek(event);
        },

        stopDrag() {
            this.isDragging = false;
        },

        toggleMute() {
            if (!this.$refs.audio) return;
            this.muted = !this.muted;
            this.$refs.audio.muted = this.muted;
        },

        setVolume() {
            if (!this.$refs.audio) return;
            this.$refs.audio.volume = this.volume / 100;
            if (this.volume > 0) {
                this.muted = false;
                this.$refs.audio.muted = false;
            }
        },

        handleError() {
            this.error = 'No sha pogut carregar audio';
            this.playing = false;
        },

        formatTime(seconds) {
            if (isNaN(seconds) || seconds === 0) return '0:00';
            const mins = Math.floor(seconds / 60);
            const secs = Math.floor(seconds % 60);
            return mins + ':' + (secs < 10 ? '0' : '') + secs;
        }
    }"
    x-init="init()"
    class="py-4"
>
    <audio
        x-ref="audio"
        :src="audioSrc"
        x-on:timeupdate="updateProgress()"
        x-on:loadedmetadata="duration = $refs.audio.duration"
        x-on:ended="playing = false"
        x-on:error="handleError()"
        preload="metadata"
    ></audio>

    <!-- Play button -->
    <div class="flex justify-center mb-4">
        <button
            x-on:click="togglePlay()"
            class="w-16 h-16 bg-gray-900 hover:bg-primary-700 text-white rounded-full flex items-center justify-center transition-colors shadow-lg"
        >
            <svg x-show="!playing" class="w-7 h-7 ml-1" fill="currentColor" viewBox="0 0 24 24">
                <path d="M8 5v14l11-7z"/>
            </svg>
            <svg x-show="playing" x-cloak class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
            </svg>
        </button>
    </div>

    <!-- Progress bar with drag support -->
    <div class="space-y-1.5 px-4"
        @mousemove.window="onDrag($event)"
        @mouseup.window="stopDrag()"
        @touchmove.window="onDrag($event)"
        @touchend.window="stopDrag()"
    >
        <div
            x-ref="progressBar"
            @mousedown="startDrag($event)"
            @touchstart="startDrag($event)"
            @click="seek($event)"
            class="h-6 flex items-center cursor-pointer group"
        >
            <div class="relative w-full h-2 bg-gray-300 rounded-full">
                <!-- Progress fill -->
                <div
                    :style="'width: ' + progress + '%'"
                    class="absolute h-full bg-gray-900 rounded-full"
                ></div>
                <!-- Drag handle -->
                <div
                    :style="'left: ' + progress + '%'"
                    class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 w-4 h-4 bg-gray-900 rounded-full shadow-md opacity-0 group-hover:opacity-100 transition-opacity"
                    :class="isDragging ? 'opacity-100 scale-110' : ''"
                ></div>
            </div>
        </div>

        <div class="flex justify-between text-xs text-gray-500">
            <span x-text="formatTime(currentTime)">0:00</span>
            <span x-text="formatTime(duration)">0:00</span>
        </div>
    </div>

    <!-- Volume control -->
    <div class="flex items-center justify-center gap-3 mt-3">
        <button
            x-on:click="toggleMute()"
            class="p-1 text-gray-600 hover:text-gray-900 transition"
        >
            <svg x-show="!muted && volume > 0" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path>
            </svg>
            <svg x-show="muted || volume === 0" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"></path>
            </svg>
        </button>

        <input
            type="range"
            min="0"
            max="100"
            x-model="volume"
            x-on:input="setVolume()"
            class="w-24 h-1 bg-gray-300 rounded-lg appearance-none cursor-pointer accent-gray-900"
        >

        <span class="text-xs text-gray-500 w-8" x-text="(muted ? 0 : volume) + '%'">75%</span>
    </div>

    <!-- Error message -->
    <div x-show="error" x-cloak class="mt-2 text-center text-sm text-primary-600">
        <span x-text="error"></span>
    </div>
</div>
