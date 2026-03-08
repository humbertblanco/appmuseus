<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Redireccio extends Model
{
    protected $table = 'redireccions';

    protected $fillable = [
        'origen',
        'desti',
        'tipus',
        'activa',
    ];

    protected $casts = [
        'activa' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('redireccions_actives'));
        static::deleted(fn () => Cache::forget('redireccions_actives'));
    }

    public function scopeActiva($query)
    {
        return $query->where('activa', true);
    }
}
