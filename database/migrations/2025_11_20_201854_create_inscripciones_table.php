<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('inscripciones', function (Blueprint $table) {
    $table->id('id_inscripcion');
    $table->unsignedBigInteger('id_usuario');
    $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->cascadeOnDelete();
    $table->unsignedBigInteger('id_evento');
    $table->foreign('id_evento')->references('id_evento')->on('eventos')->cascadeOnDelete();
    $table->timestamp('fecha_inscripcion')->useCurrent();
    $table->string('estado', 20)->default('confirmada');
    $table->unique(['id_usuario', 'id_evento']);
});

    }

    public function down(): void
    {
        Schema::dropIfExists('inscripciones');
    }
};
