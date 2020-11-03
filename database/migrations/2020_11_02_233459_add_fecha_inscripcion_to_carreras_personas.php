<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFechaInscripcionToCarrerasPersonas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carreras_personas', function (Blueprint $table) {
            $table->date('fecha_inscripcion')->nullable()->after('paralelo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carreras_personas', function (Blueprint $table) {
            $table->dropColumn('fecha_inscripcion');
        });
    }
}
