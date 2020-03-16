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
            $table->unsignedBigInteger('carrera_id');
            $table->foreign('carrera_id')->references('id')->on('carreras');
            $table->string('gestion', 30)->nullable();
            $table->string('codigo_asignatura', 10)->nullable();
            $table->string('nombre_asignatura', 150)->nullable();
            $table->integer('carga_horaria');
            $table->integer('teorico');
            $table->integer('practico');
            $table->integer('nivel');
            $table->integer('semestre');
            $table->string('periodo', 20)->nullable();
            $table->integer('anio_vigente');
            $table->integer('orden_impresion');
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
