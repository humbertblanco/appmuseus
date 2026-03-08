<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PecaImatge extends Model
{
    protected $table = 'peca_imatges';

    protected $fillable = [
        'peca_id',
        'url',
        'alt_text',
        'ordre',
    ];

    public function peca(): BelongsTo
    {
        return $this->belongsTo(Peca::class);
    }
}
