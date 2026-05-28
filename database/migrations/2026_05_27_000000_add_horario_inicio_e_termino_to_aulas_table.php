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
        Schema::table('aulas', function (Blueprint $table) {
            if (!Schema::hasColumn('aulas', 'horario_inicio')) {
                $table->time('horario_inicio')->nullable()->after('data');
            }

            if (!Schema::hasColumn('aulas', 'horario_termino')) {
                $table->time('horario_termino')->nullable()->after('horario_inicio');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aulas', function (Blueprint $table) {
            if (Schema::hasColumn('aulas', 'horario_termino')) {
                $table->dropColumn('horario_termino');
            }

            if (Schema::hasColumn('aulas', 'horario_inicio')) {
                $table->dropColumn('horario_inicio');
            }
        });
    }
};