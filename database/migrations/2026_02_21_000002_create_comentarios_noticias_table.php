<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comentarios_noticias', function (Blueprint $table) {
            $table->id('id_comentario');
            $table->unsignedBigInteger('id_noticia');
            $table->unsignedBigInteger('id_usuario');
            $table->text('comentario');
            $table->foreign('id_noticia')->references('id_noticia')->on('noticias')->cascadeOnDelete();
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comentarios_noticias');
    }
};
