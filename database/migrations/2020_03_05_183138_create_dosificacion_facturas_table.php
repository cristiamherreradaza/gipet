<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDosificacionFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosificacion_facturas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('n_inicio');
            $table->integer('n_final');
            $table->date('fec_inicio');
            $table->date('fec_final');
            $table->dateTime('fec_registro');
            $table->integer('tiempo');
            $table->string('llave_dosifica', 255);
            $table->string('nit_e', 12);
            $table->string('auto_e', 15);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dosificacion_facturas');
    }
}
