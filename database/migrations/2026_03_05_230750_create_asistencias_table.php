<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id('id_asistencia');
            $table->unsignedBigInteger('id_evento');
            $table->unsignedBigInteger('id_usuario');   // alumno
            $table->date('fecha');
            $table->enum('estado', ['presente', 'ausente', 'justificado'])->default('ausente');
            $table->string('nota', 255)->nullable();
            $table->timestamps();

            $table->foreign('id_evento')->references('id_evento')->on('eventos')->onDelete('cascade');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade');

            // Un alumno solo puede tener un registro por día por taller
            $table->unique(['id_evento', 'id_usuario', 'fecha']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
