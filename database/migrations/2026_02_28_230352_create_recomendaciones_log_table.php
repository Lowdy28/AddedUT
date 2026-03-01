<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recomendaciones_log', function (Blueprint $table) {
            $table->id('id_log');

            $table->unsignedBigInteger('id_usuario');
            $table->foreign('id_usuario')
                  ->references('id_usuario')
                  ->on('usuarios')
                  ->cascadeOnDelete();

            $table->unsignedBigInteger('id_evento');
            $table->foreign('id_evento')
                  ->references('id_evento')
                  ->on('eventos')
                  ->cascadeOnDelete();

            $table->decimal('score', 5, 2)->default(0);

            $table->tinyInteger('posicion')->default(1);

            $table->boolean('inscrito')->nullable()->default(null);

            $table->timestamp('fecha_recomendacion')->useCurrent();

            $table->index(['id_usuario', 'fecha_recomendacion']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recomendaciones_log');
    }
};
