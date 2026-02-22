<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('likes_noticias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_noticia');
            $table->unsignedBigInteger('id_usuario');
            $table->foreign('id_noticia')->references('id_noticia')->on('noticias')->cascadeOnDelete();
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->cascadeOnDelete();
            $table->unique(['id_noticia', 'id_usuario']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('likes_noticias');
    }
};
