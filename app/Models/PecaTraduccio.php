<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PecaTraduccio extends Model
{
    protected $table = 'peca_traduccions';

    protected $fillable = [
        'peca_id',
        'idioma',
        'titol',
        'subtitol',
        'periode',
        'descripcio',
        'audio_url',
        'audio_descripcio_url',
        'text_audiodescripcio',
    ];

    public function peca(): BelongsTo
    {
        return $this->belongsTo(Peca::class);
    }

    public function teAudiodescripcio(): bool
    {
        return !empty($this->audio_descripcio_url) || !empty($this->text_audiodescripcio);
    }

    public function teAudioDescripcioAudio(): bool
    {
        return !empty($this->audio_descripcio_url);
    }
}
