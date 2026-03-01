<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_intereses', function (Blueprint $table) {
            $table->id('id_interes');

            $table->unsignedBigInteger('id_usuario');
            $table->foreign('id_usuario')
                  ->references('id_usuario')
                  ->on('usuarios')
                  ->cascadeOnDelete();

            $table->string('tipo_actividad', 20);

            $table->string('modalidad', 20);

            $table->string('experiencia', 20);

            $table->string('horario_preferido', 20);

            $table->string('objetivo', 20);

            $table->boolean('cuestionario_completado')->default(false);

            $table->timestamps();

            $table->unique('id_usuario');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_intereses');
    }
};
