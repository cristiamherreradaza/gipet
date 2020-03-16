<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKardexTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kardex', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('codigo_anterior')->nullable();
            $table->unsignedBigInteger('persona_id');
            $table->foreign('persona_id')->references('id')->on('personas');
            $table->unsignedBigInteger('asignatura_id');
            $table->foreign('asignatura_id')->references('id')->on('asignaturas');
            $table->unsignedBigInteger('carrera_id');
            $table->foreign('carrera_id')->references('id')->on('carreras');
            $table->unsignedBigInteger('turno_id');
            $table->foreign('turno_id')->references('id')->on('turnos');
            $table->string('paralelo', 10)->nullable();
            $table->string('gestion', 30)->nullable();
            $table->string('aprobado', 10)->nullable();
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
        Schema::dropIfExists('kardex');
    }
}
