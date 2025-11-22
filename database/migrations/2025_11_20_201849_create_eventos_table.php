<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('eventos', function (Blueprint $table) {
    $table->id('id_evento');
    $table->string('nombre');
    $table->text('descripcion');
    $table->string('categoria');
    $table->integer('cupos');
    $table->unsignedBigInteger('creado_por'); // id del profesor
    $table->foreign('creado_por')->references('id_usuario')->on('usuarios')->cascadeOnDelete();
    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
