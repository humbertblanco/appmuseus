<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Peca extends Model
{
    protected $table = 'peces';

    protected $fillable = [
        'exposicio_id',
        'slug',
        'ordre',
        'activa',
    ];

    protected $casts = [
        'activa' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Peca $peca) {
            if (empty($peca->ordre) || $peca->ordre == 0) {
                $peca->ordre = (static::where('exposicio_id', $peca->exposicio_id)->max('ordre') ?? 0) + 1;
            }
        });
    }

    public function exposicio(): BelongsTo
    {
        return $this->belongsTo(Exposicio::class);
    }

    public function traduccions(): HasMany
    {
        return $this->hasMany(PecaTraduccio::class);
    }

    public function imatges(): HasMany
    {
        return $this->hasMany(PecaImatge::class)->orderBy('ordre');
    }

    public function materials(): HasMany
    {
        return $this->hasMany(PecaMaterial::class);
    }

    public function estadistiques(): HasMany
    {
        return $this->hasMany(Estadistica::class);
    }

    public function traduccio(string $idioma): ?PecaTraduccio
    {
        return $this->traduccions->firstWhere('idioma', $idioma);
    }

    public function idiomesDisponibles(): array
    {
        return $this->traduccions->pluck('idioma')->toArray();
    }

    public function materialsPerIdioma(string $idioma): \Illuminate\Database\Eloquent\Collection
    {
        return $this->materials->where('idioma', $idioma);
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
