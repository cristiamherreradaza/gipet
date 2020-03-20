<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transacciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('codigo_anterior')->nullable();
            $table->unsignedBigInteger('servicio_id')->nullable();
            $table->foreign('servicio_id')->references('id')->on('servicios');
            $table->unsignedBigInteger('persona_id')->nullable();
            $table->foreign('persona_id')->references('id')->on('personas');
            $table->unsignedBigInteger('kardex_id')->nullable();
            $table->foreign('kardex_id')->references('id')->on('kardex');
            $table->integer('numero_mensualidad')->nullable();
            $table->dateTime('fecha', 0)->nullable();
            $table->integer('monto')->nullable();
            $table->integer('saldo')->nullable();
            $table->string('pendiente', 20)->nullable();
            $table->string('estado', 15)->nullable();
            $table->datetime('borrado', 0)->nullable();
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
        Schema::dropIfExists('transacciones');
    }
}
