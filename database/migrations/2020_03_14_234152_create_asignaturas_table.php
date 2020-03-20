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
            $table->unsignedBigInteger('carrera_id')->nullable();
            $table->foreign('carrera_id')->references('id')->on('carreras');
            $table->string('gestion', 30)->nullable();
            $table->string('codigo_asignatura', 10)->nullable();
            $table->string('nombre_asignatura', 150)->nullable();
            $table->integer('carga_horaria')->nullable();
            $table->integer('teorico')->nullable();
            $table->integer('practico')->nullable();
            $table->integer('nivel')->nullable();
            $table->integer('semestre')->nullable();
            $table->string('periodo', 20)->nullable();
            $table->integer('anio_vigente')->nullable();
            $table->integer('orden_impresion')->nullable();
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
        Schema::dropIfExists('asignaturas');
    }
}
