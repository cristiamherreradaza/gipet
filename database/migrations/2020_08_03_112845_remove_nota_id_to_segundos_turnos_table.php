<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveNotaIdToSegundosTurnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('segundos_turnos', function (Blueprint $table) {
            $table->dropForeign(['nota_id']);
            $table->dropColumn('nota_id');
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
            $table->unsignedBigInteger('nota_id')->after('codigo_anterior');
            $table->foreign('nota_id')->references('id')->on('notas');
        });
    }
}
