<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNombreComboToCobrosTemporadas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cobros_temporadas', function (Blueprint $table) {
            $table->integer('nombre_combo')->nullable()->after('fecha_generado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cobros_temporadas', function (Blueprint $table) {
            $table->dropColumn('nombre_combo');
        });
    }
}
