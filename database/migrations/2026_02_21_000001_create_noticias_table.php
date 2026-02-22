<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('noticias', function (Blueprint $table) {
            $table->id('id_noticia');
            $table->string('titulo', 200);
            $table->text('contenido');
            $table->string('imagen')->nullable();
            $table->string('categoria', 80)->default('General');
            $table->boolean('publicada')->default(true);
            $table->unsignedBigInteger('publicado_por');
            $table->foreign('publicado_por')->references('id_usuario')->on('usuarios')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('noticias');
    }
};
