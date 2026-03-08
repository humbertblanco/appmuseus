<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExposicioTraduccio extends Model
{
    protected $table = 'exposicio_traduccions';

    protected $fillable = [
        'exposicio_id',
        'idioma',
        'titol',
        'descripcio',
        'adreca',
        'telefon',
        'email',
        'web_url',
        'facebook_url',
        'instagram_url',
    ];

    public function exposicio(): BelongsTo
    {
        return $this->belongsTo(Exposicio::class);
    }
}
