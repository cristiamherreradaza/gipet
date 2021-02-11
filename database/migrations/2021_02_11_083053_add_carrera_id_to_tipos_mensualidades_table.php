<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCarreraIdToTiposMensualidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tipos_mensualidades', function (Blueprint $table) {
            $table->unsignedBigInteger('carrera_id')->nullable()->after('user_id');
            $table->foreign('carrera_id')->references('id')->on('carreras');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tipos_mensualidades', function (Blueprint $table) {
            $table->dropForeign(['carrera_id']);
            $table->dropColumn('carrera_id');
        });
    }
}
