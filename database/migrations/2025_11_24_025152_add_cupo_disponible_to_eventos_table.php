<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('eventos', function (Blueprint $table) {
        if (!Schema::hasColumn('eventos', 'cupo_disponible')) {
            $table->integer('cupo_disponible')->nullable()->after('cupos');
        }
    });

    // llenar cupo_disponible con el valor de cupos
    \DB::table('eventos')->whereNotNull('cupos')->update(['cupo_disponible' => \DB::raw('cupos')]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('eventos', function (Blueprint $table) {
        if (Schema::hasColumn('eventos', 'cupo_disponible')) {
            $table->dropColumn('cupo_disponible');
        }
    });
    }
};
