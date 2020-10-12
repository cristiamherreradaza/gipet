<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsignaturasEquivalentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asignaturas_equivalentes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('carrera_id_1')->nullable();
            $table->foreign('carrera_id_1')->references('id')->on('carreras');
            $table->unsignedBigInteger('carrera_id_2')->nullable();
            $table->foreign('carrera_id_2')->references('id')->on('carreras');
            $table->unsignedBigInteger('asignatura_id_1')->nullable();
            $table->foreign('asignatura_id_1')->references('id')->on('asignaturas');
            $table->unsignedBigInteger('asignatura_id_2')->nullable();
            $table->foreign('asignatura_id_2')->references('id')->on('asignaturas');
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
        Schema::dropIfExists('asignaturas_equivalentes');
    }
}
