<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFechaToDescuentosPersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('descuentos_personas', function (Blueprint $table) {
            $table->date('fecha')->nullable()->after('a_pagar');
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
            $table->dropColumn('fecha');
        });
    }
}
