<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Museum / Institution Name
    |--------------------------------------------------------------------------
    | The name of your museum or cultural institution.
    */
    'name' => env('MUSEUM_NAME', 'Museum Audioguide'),

    /*
    |--------------------------------------------------------------------------
    | Institution Name (for footer)
    |--------------------------------------------------------------------------
    */
    'institution' => env('MUSEUM_INSTITUTION', 'My Museum'),

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    | Path to the logo image relative to the public directory.
    | Place your logo in public/images/ and set the filename here.
    */
    'logo' => env('MUSEUM_LOGO', 'images/logo.png'),

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    */
    'favicon' => env('MUSEUM_FAVICON', 'favicon.ico'),

    /*
    |--------------------------------------------------------------------------
    | Primary Color
    |--------------------------------------------------------------------------
    | The primary color used throughout the app (Filament admin panel).
    | Options: Slate, Gray, Zinc, Neutral, Stone, Red, Orange, Amber,
    | Yellow, Lime, Green, Emerald, Teal, Cyan, Sky, Blue, Indigo,
    | Violet, Purple, Fuchsia, Pink, Rose
    */
    'primary_color' => env('MUSEUM_PRIMARY_COLOR', 'Blue'),

    /*
    |--------------------------------------------------------------------------
    | Default Language
    |--------------------------------------------------------------------------
    | The default language for the public frontend.
    | Supported: ca, es, en, fr
    */
    'default_locale' => env('MUSEUM_DEFAULT_LOCALE', 'ca'),

    /*
    |--------------------------------------------------------------------------
    | Available Languages
    |--------------------------------------------------------------------------
    | Languages available for the public frontend.
    */
    'locales' => explode(',', env('MUSEUM_LOCALES', 'ca,es,en,fr')),

    /*
    |--------------------------------------------------------------------------
    | Legal / Privacy URL
    |--------------------------------------------------------------------------
    */
    'legal_url' => env('MUSEUM_LEGAL_URL', ''),

    /*
    |--------------------------------------------------------------------------
    | Footer Credit
    |--------------------------------------------------------------------------
    */
    'footer_credit' => env('MUSEUM_FOOTER_CREDIT', ''),

    /*
    |--------------------------------------------------------------------------
    | Font Family
    |--------------------------------------------------------------------------
    | Google Font name for the admin panel.
    */
    'font' => env('MUSEUM_FONT', 'Montserrat'),
];
