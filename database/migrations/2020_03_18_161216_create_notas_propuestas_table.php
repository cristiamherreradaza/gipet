<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotasPropuestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notas_propuestas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('codigo_anterior')->nullable();
            $table->unsignedBigInteger('asignatura_id')->nullable();
            $table->foreign('asignatura_id')->references('id')->on('asignaturas');
            $table->unsignedBigInteger('turno_id')->nullable();
            $table->foreign('turno_id')->references('id')->on('turnos');
            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->foreign('usuario_id')->references('id')->on('usuarios');
            $table->string('paralelo', 10)->nullable();
            $table->string('gestion', 30)->nullable();
            $table->dateTime('fecha', 0)->nullable();
            $table->decimal('nota_asistencia', 8, 2)->nullable();
            $table->decimal('nota_practicas', 8, 2)->nullable();
            $table->decimal('nota_puntos_ganados', 8, 2)->nullable();
            $table->decimal('nota_primer_parcial', 8, 2)->nullable();
            $table->decimal('nota_examen_final', 8, 2)->nullable();
            $table->string('validado', 10)->nullable();
            $table->string('vigente', 10)->nullable();
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
        Schema::dropIfExists('notas_propuestas');
    }
}
