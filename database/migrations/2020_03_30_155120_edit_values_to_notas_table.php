<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditValuesToNotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notas', function (Blueprint $table) {
            $table->decimal('nota_asistencia', 8, 2)->nullable()->default(0)->change();
            $table->decimal('nota_practicas', 8, 2)->nullable()->default(0)->change();
            $table->decimal('nota_puntos_ganados', 8, 2)->nullable()->default(0)->change();
            $table->decimal('nota_primer_parcial', 8, 2)->nullable()->default(0)->change();
            $table->decimal('nota_examen_final', 8, 2)->nullable()->default(0)->change();
            $table->decimal('nota_total', 8, 2)->nullable()->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notas', function (Blueprint $table) {
            $table->decimal('nota_asistencia', 8, 2)->nullable()->change();
            $table->decimal('nota_practicas', 8, 2)->nullable()->change();
            $table->decimal('nota_puntos_ganados', 8, 2)->nullable()->change();
            $table->decimal('nota_primer_parcial', 8, 2)->nullable()->change();
            $table->decimal('nota_examen_final', 8, 2)->nullable()->change();
            $table->decimal('nota_total', 8, 2)->nullable()->change();
        });
    }
}
