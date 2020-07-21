<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCobrosTemporadasIdToTransaccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transacciones', function (Blueprint $table) {
            $table->unsignedBigInteger('cobros_temporadas_id')->nullable()->after('persona_id');
            $table->foreign('cobros_temporadas_id')->references('id')->on('cobros_temporadas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transacciones', function (Blueprint $table) {
            $table->dropForeign(['cobros_temporadas_id']);
            $table->dropColumn('cobros_temporadas_id');
        });
    }
}
