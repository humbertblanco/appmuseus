<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExposicioDocument extends Model
{
    protected $table = 'exposicio_documents';

    protected $fillable = [
        'exposicio_id',
        'idioma',
        'titol',
        'descripcio',
        'fitxer',
        'ordre',
        'actiu',
    ];

    protected $casts = [
        'actiu' => 'boolean',
    ];

    public function exposicio(): BelongsTo
    {
        return $this->belongsTo(Exposicio::class);
    }

    public function scopeActiu($query)
    {
        return $query->where('actiu', true);
    }

    public function scopePerIdioma($query, string $idioma)
    {
        return $query->where('idioma', $idioma);
    }
}
