<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParaleloToCarrerasPersonas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carreras_personas', function (Blueprint $table) {
            $table->string('paralelo', 10)->nullable()->after('turno_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carreras_personas', function (Blueprint $table) {
            $table->dropColumn('paralelo');
        });
    }
}
