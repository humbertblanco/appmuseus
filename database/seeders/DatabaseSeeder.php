<?php

namespace Database\Seeders;

use App\Models\Exposicio;
use App\Models\ExposicioTraduccio;
use App\Models\Peca;
use App\Models\PecaTraduccio;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
        ]);

        User::create([
            'name' => 'Editor',
            'email' => 'editor@example.com',
            'password' => Hash::make('password'),
            'role' => 'editor',
        ]);

        // Create sample exhibition
        $exposicio = Exposicio::create([
            'slug' => 'sample-exhibition',
            'ordre' => 1,
            'activa' => true,
        ]);

        ExposicioTraduccio::create([
            'exposicio_id' => $exposicio->id,
            'idioma' => 'ca',
            'titol' => 'Exposicio de mostra',
            'descripcio' => 'Aquesta es una exposicio de mostra per demostrar les funcionalitats de l\'aplicacio. Personalitzeu-la des del panell d\'administracio.',
            'adreca' => 'Carrer Principal, 1',
            'telefon' => '+34 900 000 000',
            'email' => 'info@example.com',
            'web_url' => 'https://example.com',
        ]);

        ExposicioTraduccio::create([
            'exposicio_id' => $exposicio->id,
            'idioma' => 'es',
            'titol' => 'Exposicion de muestra',
            'descripcio' => 'Esta es una exposicion de muestra para demostrar las funcionalidades de la aplicacion. Personalizadla desde el panel de administracion.',
            'adreca' => 'Calle Principal, 1',
            'telefon' => '+34 900 000 000',
            'email' => 'info@example.com',
            'web_url' => 'https://example.com',
        ]);

        ExposicioTraduccio::create([
            'exposicio_id' => $exposicio->id,
            'idioma' => 'en',
            'titol' => 'Sample Exhibition',
            'descripcio' => 'This is a sample exhibition to demonstrate the application features. Customize it from the admin panel.',
            'adreca' => 'Main Street, 1',
            'telefon' => '+34 900 000 000',
            'email' => 'info@example.com',
            'web_url' => 'https://example.com',
        ]);

        // Create sample pieces
        $peces = [
            [
                'slug' => 'main-hall',
                'ca' => [
                    'titol' => 'Sala Principal',
                    'subtitol' => 'Espai central',
                    'descripcio' => 'Descripcio de la sala principal. Editeu-la des del panell d\'administracio.',
                ],
                'es' => [
                    'titol' => 'Sala Principal',
                    'subtitol' => 'Espacio central',
                    'descripcio' => 'Descripcion de la sala principal. Editadla desde el panel de administracion.',
                ],
                'en' => [
                    'titol' => 'Main Hall',
                    'subtitol' => 'Central space',
                    'descripcio' => 'Main hall description. Edit it from the admin panel.',
                ],
            ],
            [
                'slug' => 'gallery',
                'ca' => [
                    'titol' => 'Galeria',
                    'subtitol' => 'Espai expositiu',
                    'descripcio' => 'Descripcio de la galeria. Editeu-la des del panell d\'administracio.',
                ],
                'es' => [
                    'titol' => 'Galeria',
                    'subtitol' => 'Espacio expositivo',
                    'descripcio' => 'Descripcion de la galeria. Editadla desde el panel de administracion.',
                ],
                'en' => [
                    'titol' => 'Gallery',
                    'subtitol' => 'Exhibition space',
                    'descripcio' => 'Gallery description. Edit it from the admin panel.',
                ],
            ],
        ];

        foreach ($peces as $index => $pecaData) {
            $peca = Peca::create([
                'exposicio_id' => $exposicio->id,
                'slug' => $pecaData['slug'],
                'ordre' => $index + 1,
                'activa' => true,
            ]);

            foreach (['ca', 'es', 'en'] as $idioma) {
                if (isset($pecaData[$idioma])) {
                    PecaTraduccio::create([
                        'peca_id' => $peca->id,
                        'idioma' => $idioma,
                        'titol' => $pecaData[$idioma]['titol'],
                        'subtitol' => $pecaData[$idioma]['subtitol'] ?? null,
                        'descripcio' => $pecaData[$idioma]['descripcio'] ?? null,
                    ]);
                }
            }
        }

        $this->command->info('Seeder completed!');
        $this->command->info('Admin user: admin@example.com / password');
        $this->command->warn('IMPORTANT: Change the default password after first login!');
    }
}
