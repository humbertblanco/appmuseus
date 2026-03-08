<?php

namespace App\Helpers;

class ColorHelper
{
    /**
     * Get the CSS custom properties for the selected primary color palette.
     * These override the Tailwind @theme defaults at runtime.
     */
    public static function getCssVariables(): string
    {
        $colorName = strtolower(config('museum.primary_color', 'blue'));
        $palettes = config('museum.palettes', []);
        $palette = $palettes[$colorName] ?? $palettes['blue'] ?? [];

        if (empty($palette)) {
            return '';
        }

        $css = ':root {' . PHP_EOL;
        foreach ($palette as $shade => $hex) {
            // Allow per-shade overrides via env
            $envOverride = env("MUSEUM_COLOR_{$shade}");
            $value = $envOverride ?: $hex;
            $css .= "  --color-primary-{$shade}: {$value};" . PHP_EOL;
        }
        $css .= '}';

        return $css;
    }

    /**
     * Get the hero gradient CSS classes.
     * Returns auto-generated gradient from primary color if not custom-set.
     */
    public static function getHeroGradient(): string
    {
        $custom = config('museum.hero_gradient');
        if (!empty($custom)) {
            return $custom;
        }

        // Auto-generate from primary color
        return 'from-gray-900 via-gray-800 to-primary-900';
    }

    /**
     * Get the Filament Color constant for the admin panel.
     */
    public static function getFilamentColor(): array
    {
        $colorName = ucfirst(strtolower(config('museum.primary_color', 'Blue')));
        $colorClass = "\\Filament\\Support\\Colors\\Color";

        if (defined("{$colorClass}::{$colorName}")) {
            return constant("{$colorClass}::{$colorName}");
        }

        return \Filament\Support\Colors\Color::Blue;
    }
}
