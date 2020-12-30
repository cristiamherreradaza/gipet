<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResolucionIdToAsignaturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asignaturas', function (Blueprint $table) {
            $table->unsignedBigInteger('resolucion_id')->nullable()->after('user_id');
            $table->foreign('resolucion_id')->references('id')->on('resoluciones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asignaturas', function (Blueprint $table) {
            $table->dropForeign(['resolucion_id']);
            $table->dropColumn('resolucion_id');
        });
    }
}
