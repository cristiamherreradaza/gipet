<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCarreraIdToCobrosTemporadas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cobros_temporadas', function (Blueprint $table) {
            $table->integer('carrera_id')->nullable()->after('persona_id');
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
            $table->dropColumn('carrera_id');
        });
    }
}
