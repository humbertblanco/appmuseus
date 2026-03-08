<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Reassignar ordres seqüencials a exposicions (1, 2, 3...)
        $exposicions = DB::table('exposicions')->orderBy('ordre')->orderBy('id')->get();
        foreach ($exposicions as $i => $exposicio) {
            DB::table('exposicions')->where('id', $exposicio->id)->update(['ordre' => $i + 1]);
        }

        // Reassignar ordres seqüencials a peces dins cada exposició (1, 2, 3...)
        $exposicioIds = DB::table('exposicions')->pluck('id');
        foreach ($exposicioIds as $exposicioId) {
            $peces = DB::table('peces')
                ->where('exposicio_id', $exposicioId)
                ->orderBy('ordre')
                ->orderBy('id')
                ->get();

            foreach ($peces as $i => $peca) {
                DB::table('peces')->where('id', $peca->id)->update(['ordre' => $i + 1]);
            }
        }
    }

    public function down(): void
    {
        // No es pot revertir
    }
};
