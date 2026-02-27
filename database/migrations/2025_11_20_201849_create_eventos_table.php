<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('eventos', function (Blueprint $table) {
            if (!Schema::hasColumn('eventos', 'imagen')) {
                $table->string('imagen')->nullable()->after('nombre')
                      ->comment('Ruta relativa a public/imagenes/ o null para usar imagen por defecto');
            }
        });

        // Asignar imagen automáticamente a los registros existentes según nombre
        $mapa = [
            'Bailes de Salón'   => 'imagenes/baile.jpg',
            'Música'            => 'imagenes/musica.jpg',
            'Oratoria y Dibujo' => 'imagenes/dibujo.jpg',
            'Teatro'            => 'imagenes/teatro.jpg',
            'Ajedrez'           => 'imagenes/ajedrez.jpg',
            'Basquetbol'        => 'imagenes/basquet.jpg',
            'Fútbol americano'  => 'imagenes/americano.jpg',
            'Fútbol rápido y 7' => 'imagenes/frapido.jpg',
            'Fútbol soccer'     => 'imagenes/soccer.jpg',
            'Taekwondo'         => 'imagenes/taekwdo.jpg',
            'Voleibol'          => 'imagenes/volei.jpg',
        ];

        foreach ($mapa as $nombre => $ruta) {
            DB::table('eventos')
                ->where('nombre', $nombre)
                ->whereNull('imagen')
                ->update(['imagen' => $ruta]);
        }
    }

    public function down(): void
    {
        Schema::table('eventos', function (Blueprint $table) {
            if (Schema::hasColumn('eventos', 'imagen')) {
                $table->dropColumn('imagen');
            }
        });
    }
};
