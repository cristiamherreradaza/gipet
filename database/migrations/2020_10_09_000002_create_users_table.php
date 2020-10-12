<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('codigo_anterior')->nullable();
            $table->unsignedBigInteger('perfil_id')->nullable();
            $table->foreign('perfil_id')->references('id')->on('perfiles');
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('nombres')->nullable();
            $table->string('nomina')->nullable();
            $table->string('password')->nullable();
            $table->string('cedula')->nullable();
            $table->string('expedido')->nullable();
            $table->string('tipo_usuario')->nullable();
            $table->string('nombre_usuario')->nullable();
            $table->date('fecha_incorporacion')->nullable();
            $table->string('vigente')->nullable();
            $table->string('rol')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('lugar_nacimiento')->nullable();
            $table->string('sexo')->nullable();
            $table->string('estado_civil')->nullable();
            $table->string('nombre_conyugue')->nullable();
            $table->string('nombre_hijo')->nullable();
            $table->string('direccion')->nullable();
            $table->string('zona')->nullable();
            $table->string('numero_celular')->nullable();
            $table->string('numero_fijo')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('foto')->nullable();
            $table->string('persona_referencia')->nullable();
            $table->string('numero_referencia')->nullable();
            $table->string('name')->nullable();
            $table->string('estado')->nullable();
            $table->datetime('deleted_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
