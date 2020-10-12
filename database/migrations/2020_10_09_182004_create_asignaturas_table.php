<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsignaturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asignaturas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('codigo_anterior')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('carrera_id')->nullable();
            $table->foreign('carrera_id')->references('id')->on('carreras');
            $table->integer('gestion')->nullable();
            $table->string('sigla')->nullable();    //codigo_asignatura
            $table->string('nombre')->nullable();    //nombre_asignatura
            $table->string('ciclo')->nullable();
            $table->integer('semestre')->nullable();
            $table->integer('carga_horaria_virtual')->nullable();
            $table->integer('carga_horaria')->nullable();
            $table->integer('teorico')->nullable();
            $table->integer('practico')->nullable();
            $table->integer('nivel')->nullable();
            $table->string('periodo')->nullable();
            $table->integer('anio_vigente')->nullable();
            $table->integer('orden_impresion')->nullable();
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
        Schema::dropIfExists('asignaturas');
    }
}
