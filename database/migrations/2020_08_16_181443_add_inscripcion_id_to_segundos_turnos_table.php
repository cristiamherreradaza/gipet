<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInscripcionIdToSegundosTurnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('segundos_turnos', function (Blueprint $table) {
            $table->unsignedBigInteger('inscripcion_id')->nullable()->after('nota_id');
            $table->foreign('inscripcion_id')->references('id')->on('inscripciones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('segundos_turnos', function (Blueprint $table) {
             $table->dropForeign(['inscripcion_id']);
            $table->dropColumn('inscripcion_id');
        });
    }
}
