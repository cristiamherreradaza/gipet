<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('codigo_anterior')->nullable();
            $table->string('apellido_paterno', 20)->nullable();
            $table->string('apellido_materno', 20)->nullable();
            $table->string('nombres', 120)->nullable();
            $table->string('nomina', 5)->nullable();
            $table->string('password', 100)->nullable();
            $table->string('cedula', 20)->nullable();
            $table->string('expedido', 20)->nullable();
            $table->string('tipo_usuario', 10)->nullable();
            $table->string('nombre_usuario', 30)->nullable();
            $table->date('fecha_incorporacion');
            $table->string('vigente', 10)->nullable();
            $table->text('rol');
            $table->date('fecha_nacimiento');
            $table->string('lugar_nacimiento', 60)->nullable();
            $table->enum('sexo', ['Femenino', 'Masculino'])->nullable();
            $table->string('estado_civil', 20)->nullable();
            $table->string('nombre_conyugue', 50)->nullable();
            $table->string('nombre_hijo', 100)->nullable();
            $table->string('direccion', 150)->nullable();
            $table->string('zona', 30)->nullable();
            $table->string('numero_celular', 25)->nullable();
            $table->string('numero_fijo', 30)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('foto', 200)->nullable();
            $table->string('persona_referencia', 60)->nullable();
            $table->string('numero_referencia', 30)->nullable();
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
        Schema::dropIfExists('usuarios');
    }
}
