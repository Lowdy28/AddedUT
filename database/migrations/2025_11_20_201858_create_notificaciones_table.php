<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id('id_notificacion');

            $table->unsignedBigInteger('id_usuario');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->cascadeOnDelete();

            $table->text('mensaje');
            $table->enum('tipo', ['correo', 'alerta_web', 'sistema']);
            $table->boolean('leida')->default(false);
            $table->timestamp('fecha_envio')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};
