<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCobrosTemporadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cobros_temporadas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('codigo_anterior')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('carrera_id')->nullable();
            $table->foreign('carrera_id')->references('id')->on('carreras');
            $table->unsignedBigInteger('asignatura_id')->nullable();
            $table->foreign('asignatura_id')->references('id')->on('asignaturas');
            $table->unsignedBigInteger('servicio_id')->nullable();
            $table->foreign('servicio_id')->references('id')->on('servicios');
            $table->unsignedBigInteger('persona_id')->nullable();
            $table->foreign('persona_id')->references('id')->on('personas');
            $table->string('nombre')->nullable();
            $table->integer('mensualidad')->nullable();
            $table->integer('gestion')->nullable();
            $table->date('fecha_generado')->nullable();
            $table->string('nombre_combo')->nullable();
            $table->integer('anio_vigente')->nullable();
            $table->string('estado')->nullable();
            $table->datetime('deleted_at')->nullable();
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
        Schema::dropIfExists('cobros_temporadas');
    }
}
