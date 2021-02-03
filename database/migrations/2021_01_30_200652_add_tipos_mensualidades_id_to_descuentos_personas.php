<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTiposMensualidadesIdToDescuentosPersonas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('descuentos_personas', function (Blueprint $table) {
            $table->unsignedBigInteger('tipos_mensualidades_id')->nullable()->after('user_id');
            $table->foreign('tipos_mensualidades_id')->references('id')->on('tipos_mensualidades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('descuentos_personas', function (Blueprint $table) {
            $table->dropForeign(['tipos_mensualidades_id']);
            $table->dropColumn('tipos_mensualidades_id');
        });
    }
}
