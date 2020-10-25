<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePredefinidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('predefinidas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->decimal('nota_asistencia', 15, 2)->nullable();
            $table->decimal('nota_practicas', 15, 2)->nullable();
            $table->decimal('nota_puntos_ganados', 15, 2)->nullable();
            $table->decimal('nota_primer_parcial', 15, 2)->nullable();
            $table->decimal('nota_examen_final', 15, 2)->nullable();
            $table->date('fecha')->nullable();
            $table->integer('anio_vigente')->nullable();
            $table->string('activo')->nullable();
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
        Schema::dropIfExists('predefinidas');
    }
}
