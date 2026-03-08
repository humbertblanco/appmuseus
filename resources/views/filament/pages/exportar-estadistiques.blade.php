<x-filament-panels::page>
    <form wire:submit="export">
        {{ $this->form }}

        <div class="mt-6 flex items-center gap-4">
            <x-filament::button type="submit" icon="heroicon-o-arrow-down-tray">
                Exportar
            </x-filament::button>

            <span class="text-sm text-gray-500 dark:text-gray-400">
                {{ number_format($this->getRecordCount()) }} registres trobats
            </span>
        </div>
    </form>
</x-filament-panels::page>
