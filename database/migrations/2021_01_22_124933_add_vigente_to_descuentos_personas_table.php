<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVigenteToDescuentosPersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('descuentos_personas', function (Blueprint $table) {
            $table->string('vigente')->nullable()->after('anio_vigente');
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
            $table->dropColumn('vigente');
        });
    }
}
