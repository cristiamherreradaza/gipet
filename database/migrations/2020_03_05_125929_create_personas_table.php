<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('apellido_paterno', 150)->nullable();
            $table->string('apellido_materno', 150)->nullable();
            $table->string('nombres', 100);
            $table->string('carnet', 15);
            $table->string('expedido', 4)->nullable();
            $table->date('fecha_nacimiento');
            $table->string('sexo', 15)->nullable();
            $table->text('direccion')->nullable();
            $table->string('telefono_fijo', 8)->nullable();
            $table->string('telefono_celular', 8)->nullable();
            $table->string('email', 30)->nullable();
            $table->string('trabaja', 2)->default('No');
            $table->string('empresa', 80)->nullable();
            $table->text('direccion_empresa')->nullable();
            $table->string('telefono_empresa', 8)->nullable();
            $table->string('fax', 8)->nullable();
            $table->string('email_empresa', 50)->nullable();
            $table->string('nombre_padre', 150)->nullable();
            $table->string('celular_padre', 30)->nullable();
            $table->string('nombre_madre', 150)->nullable();
            $table->string('celular_madre', 30)->nullable();
            $table->string('nombre_tutor', 150)->nullable();
            $table->string('telefono_tutor', 10)->nullable();
            $table->string('nombre_esposo', 150)->nullable();
            $table->string('telefono_esposo', 10)->nullable();
            $table->string('estado', 15)->nullable();
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
        Schema::dropIfExists('personas');
    }
}
