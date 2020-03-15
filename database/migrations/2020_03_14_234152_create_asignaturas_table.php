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
            $table->unsignedBigInteger('carrera_id');
            $table->foreign('carrera_id')->references('id')->on('carreras');
            $table->integer('gestion');
            $table->string('codigo_asignatura', 10);
            $table->string('nombre_asignatura', 150);
            $table->integer('carga_horaria');
            $table->integer('teorico');
            $table->integer('practico');
            $table->integer('nivel');
            $table->integer('semestre');
            $table->string('periodo', 20);
            $table->integer('anio_vigente');
            $table->integer('orden_impresion');
            $table->string('compat', 10);
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
