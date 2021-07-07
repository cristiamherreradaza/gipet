<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAnioTurnoToPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pagos', function (Blueprint $table) {
            $table->unsignedBigInteger('turno_id')->nullable()->after('user_id');
            $table->foreign('turno_id')->references('id')->on('turnos');
            $table->integer('gestion')->nullable()->after('mensualidad');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pagos', function (Blueprint $table) {
            $table->dropForeign(['turno_id']);
            $table->dropColumn('turno_id');
            $table->dropColumn('gestion');
        });
    }
}
