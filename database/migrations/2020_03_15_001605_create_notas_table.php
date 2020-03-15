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
            $table->unsignedBigInteger('asignatura_id');
            $table->foreign('asignatura_id')->references('id')->on('asignaturas');
            $table->unsignedBigInteger('turno_id');
            $table->foreign('turno_id')->references('id')->on('turnos');
            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('usuarios');
            $table->unsignedBigInteger('persona_id');
            $table->foreign('persona_id')->references('id')->on('personas');
            $table->string('convalidado', 10);
            $table->string('paralelo', 10);
            $table->string('gestion', 30);
            $table->decimal('nota_asistencia', 8, 2);
            $table->decimal('nota_practicas', 8, 2);
            $table->decimal('nota_puntos_ganados', 8, 2);
            $table->decimal('nota_primer_parcial', 8, 2);
            $table->decimal('nota_examen_final', 8, 2);
            $table->decimal('nota_segundo_turno', 8, 2);
            $table->decimal('nota_total', 8, 2);
            $table->string('validado', 10);
            $table->string('registrado', 10);
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
