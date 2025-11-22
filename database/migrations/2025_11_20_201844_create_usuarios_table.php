<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('nombre', 100);
            $table->string('correo', 100)->unique();
            $table->string('password');
            $table->enum('rol', ['estudiante', 'profesor', 'admin']);
            $table->timestamp('fecha_registro')->useCurrent();
            $table->boolean('activo')->default(true);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
