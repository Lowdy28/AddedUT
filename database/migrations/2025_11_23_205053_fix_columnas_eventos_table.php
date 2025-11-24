<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('eventos', function (Blueprint $table) {
            // Agregamos columnas que faltan
            if (!Schema::hasColumn('eventos', 'fecha_inicio')) {
                $table->date('fecha_inicio')->nullable()->after('nombre');
            }

            if (!Schema::hasColumn('eventos', 'fecha_fin')) {
                $table->date('fecha_fin')->nullable()->after('fecha_inicio');
            }

            if (!Schema::hasColumn('eventos', 'lugar')) {
                $table->string('lugar')->nullable()->after('cupos');
            }

            if (!Schema::hasColumn('eventos', 'horario')) {
                $table->string('horario')->nullable()->after('lugar');
            }

            if (!Schema::hasColumn('eventos', 'dias')) {
                $table->string('dias')->nullable()->after('horario');
            }
        });
    }

    public function down(): void
    {
        Schema::table('eventos', function (Blueprint $table) {
            $table->dropColumn(['fecha_inicio', 'fecha_fin', 'lugar', 'horario', 'dias']);
        });
    }
};
