<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exposicio extends Model
{
    protected $table = 'exposicions';

    protected $fillable = [
        'slug',
        'imatge_portada',
        'ordre',
        'activa',
    ];

    protected $casts = [
        'activa' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Exposicio $exposicio) {
            if (empty($exposicio->ordre) || $exposicio->ordre == 0) {
                $exposicio->ordre = (static::max('ordre') ?? 0) + 1;
            }
        });
    }

    public function traduccions(): HasMany
    {
        return $this->hasMany(ExposicioTraduccio::class);
    }

    public function peces(): HasMany
    {
        return $this->hasMany(Peca::class)->orderBy('ordre');
    }

    public function estadistiques(): HasMany
    {
        return $this->hasMany(Estadistica::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ExposicioDocument::class)->orderBy('ordre');
    }

    public function documentsPerIdioma(string $idioma): \Illuminate\Database\Eloquent\Collection
    {
        return $this->documents()->actiu()->perIdioma($idioma)->get();
    }

    public function traduccio(string $idioma): ?ExposicioTraduccio
    {
        return $this->traduccions->firstWhere('idioma', $idioma);
    }

    public function idiomesDisponibles(): array
    {
        return $this->traduccions->pluck('idioma')->toArray();
    }

    public function scopeActiva($query)
    {
        return $query->where('activa', true);
    }

    public function scopeOrdenada($query)
    {
        return $query->orderBy('ordre');
    }
}
