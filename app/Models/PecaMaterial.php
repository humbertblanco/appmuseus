<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PecaMaterial extends Model
{
    protected $table = 'peca_materials';

    protected $fillable = [
        'peca_id',
        'idioma',
        'tipus',
        'titol',
        'url',
    ];

    public function peca(): BelongsTo
    {
        return $this->belongsTo(Peca::class);
    }
}
