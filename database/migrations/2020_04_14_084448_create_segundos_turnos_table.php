<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSegundosTurnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('segundos_turnos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('codigo_anterior')->nullable();
            $table->unsignedBigInteger('nota_id')->nullable();
            $table->foreign('nota_id')->references('id')->on('notas');
            $table->unsignedBigInteger('asignatura_id')->nullable();
            $table->foreign('asignatura_id')->references('id')->on('asignaturas');
            $table->unsignedBigInteger('turno_id')->nullable();
            $table->foreign('turno_id')->references('id')->on('turnos');
            $table->date('fecha_examen')->nullable();
            $table->string('carnet', 15)->nullable();
            $table->decimal('nota_examen', 8, 2)->nullable();
            $table->string('validado', 10)->nullable();
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
        Schema::dropIfExists('segundos_turnos');
    }
}
