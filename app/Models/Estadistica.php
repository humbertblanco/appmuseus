<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Estadistica extends Model
{
    protected $table = 'estadistiques';

    protected $fillable = [
        'peca_id',
        'exposicio_id',
        'idioma',
        'tipus',
        'user_agent',
        'ip_hash',
        'visitor_id',
        'dispositiu',
    ];

    const TIPUS_QR_SCAN = 'qr_scan';
    const TIPUS_VISITA = 'visita';
    const TIPUS_REDIRECCIO = 'redireccio';

    public function peca(): BelongsTo
    {
        return $this->belongsTo(Peca::class);
    }

    public function exposicio(): BelongsTo
    {
        return $this->belongsTo(Exposicio::class);
    }

    protected static function esBot(): bool
    {
        $ua = strtolower(request()->userAgent() ?? '');

        if (empty($ua)) {
            return true;
        }

        $bots = [
            'bot', 'crawl', 'spider', 'slurp', 'facebook', 'twitter',
            'whatsapp', 'telegram', 'preview', 'fetch', 'curl', 'wget',
            'python', 'go-http', 'java/', 'headless', 'phantom', 'selenium',
            'lighthouse', 'pagespeed', 'gtmetrix', 'pingdom', 'uptimerobot',
        ];

        foreach ($bots as $bot) {
            if (str_contains($ua, $bot)) {
                return true;
            }
        }

        return false;
    }

    protected static function detectarDispositiu(): string
    {
        $ua = strtolower(request()->userAgent() ?? '');

        if (str_contains($ua, 'tablet') || str_contains($ua, 'ipad')) {
            return 'tablet';
        }
        if (str_contains($ua, 'mobile') || str_contains($ua, 'android')) {
            return 'mobile';
        }

        return 'desktop';
    }

    public static function registrar(?Peca $peca = null, ?Exposicio $exposicio = null, ?string $idioma = null, string $tipus = self::TIPUS_VISITA): ?self
    {
        // No registrar bots
        if (static::esBot()) {
            return null;
        }

        // Clau unica per evitar comptar recarregues (30 min)
        $clau = 'estat_' . $tipus . '_' . ($peca?->id ?? 0) . '_' . ($exposicio?->id ?? $peca?->exposicio_id ?? 0);

        if (session()->has($clau) && session($clau) > now()->subMinutes(30)->timestamp) {
            return null;
        }

        // Fallback: check DB per visitor_id si la sessio no funciona
        $visitorId = request()->attributes->get('visitor_id');
        if (!session()->has($clau) && $visitorId) {
            $recent = static::where('visitor_id', $visitorId)
                ->where('peca_id', $peca?->id)
                ->where('exposicio_id', $exposicio?->id ?? $peca?->exposicio_id)
                ->where('tipus', $tipus)
                ->where('created_at', '>=', now()->subMinutes(5))
                ->exists();

            if ($recent) {
                return null;
            }
        }

        session([$clau => now()->timestamp]);

        return self::create([
            'peca_id' => $peca?->id,
            'exposicio_id' => $exposicio?->id ?? $peca?->exposicio_id,
            'idioma' => $idioma,
            'tipus' => $tipus,
            'user_agent' => request()->userAgent(),
            'ip_hash' => hash('sha256', request()->ip() . config('app.key')),
            'visitor_id' => $visitorId,
            'dispositiu' => static::detectarDispositiu(),
        ]);
    }

    public static function registrarQrScan(?Peca $peca = null, ?Exposicio $exposicio = null, ?string $idioma = null): ?self
    {
        return self::registrar($peca, $exposicio, $idioma, self::TIPUS_QR_SCAN);
    }

    public function scopeQrScans($query)
    {
        return $query->where('tipus', self::TIPUS_QR_SCAN);
    }

    public function scopeVisites($query)
    {
        return $query->where('tipus', self::TIPUS_VISITA);
    }

    public function scopeRedireccions($query)
    {
        return $query->where('tipus', self::TIPUS_REDIRECCIO);
    }
}
