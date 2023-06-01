<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActividadEconomicaCodigoProductoToServicios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('servicios', function (Blueprint $table) {
            $table->string('codigoActividad',20)->nullable()->after('anio_vigente');
            $table->string('codigoProducto',20)->nullable()->after('codigoActividad');
            $table->string('unidadMedida',20)->nullable()->after('codigoProducto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('servicios', function (Blueprint $table) {
            $table->dropColumn('codigoActividad');
            $table->dropColumn('codigoProducto');
            $table->dropColumn('unidadMedida');
        });
    }
}
