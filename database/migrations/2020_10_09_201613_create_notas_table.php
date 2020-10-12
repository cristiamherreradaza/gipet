<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('codigo_anterior')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('docente_id')->nullable();
            $table->foreign('docente_id')->references('id')->on('users');
            $table->unsignedBigInteger('persona_id')->nullable();
            $table->foreign('persona_id')->references('id')->on('personas');
            $table->unsignedBigInteger('asignatura_id')->nullable();
            $table->foreign('asignatura_id')->references('id')->on('asignaturas');
            $table->unsignedBigInteger('turno_id')->nullable();
            $table->foreign('turno_id')->references('id')->on('turnos');
            $table->string('paralelo')->nullable();
            $table->integer('anio_vigente')->nullable();
            $table->integer('semestre')->nullable();
            $table->integer('trimestre')->nullable();
            $table->date('fecha_registro')->nullable();
            $table->integer('convalidado')->nullable();
            $table->decimal('nota_asistencia', 15, 2)->nullable();
            $table->decimal('nota_practicas', 15, 2)->nullable();
            $table->decimal('nota_puntos_ganados', 15, 2)->nullable();
            $table->decimal('nota_primer_parcial', 15, 2)->nullable();
            $table->decimal('nota_examen_final', 15, 2)->nullable();
            $table->decimal('nota_total', 15, 2)->nullable();
            $table->decimal('segundo_turno', 15, 2)->nullable();
            $table->string('validado')->nullable();
            $table->string('registrado')->nullable();
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
        Schema::dropIfExists('notas');
    }
}
