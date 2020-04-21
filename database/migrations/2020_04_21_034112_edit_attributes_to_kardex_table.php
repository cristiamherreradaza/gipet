<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditAttributesToKardexTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kardex', function (Blueprint $table) {
            $table->string('fecha_registro', 30)->unsigned()->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kardex', function (Blueprint $table) {
            $table->string('fecha_registro', 0)->nullable()->change();
        });
    }
}
