<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            if (!Schema::hasColumn('usuarios', 'matricula')) {
                $table->string('matricula', 20)->nullable()->unique()->after('nombre')
                      ->comment('Matricula institucional UTTEC. Estudiantes: 10 digitos. Profesores: alfanumerico con letra inicial.');
            }
        });
    }

    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            if (Schema::hasColumn('usuarios', 'matricula')) {
                $table->dropColumn('matricula');
            }
        });
    }
};
