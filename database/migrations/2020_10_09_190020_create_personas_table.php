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
            $table->integer('codigo_anterior')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('nombres')->nullable();
            $table->string('cedula')->nullable();
            $table->string('expedido')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('sexo')->nullable();
            $table->string('direccion')->nullable();
            $table->string('numero_fijo')->nullable();      
            $table->string('numero_celular')->nullable();   
            $table->string('email')->nullable();
            $table->string('trabaja')->nullable();
            $table->string('empresa')->nullable();
            $table->string('direccion_empresa')->nullable();
            $table->string('numero_empresa')->nullable();
            $table->string('fax')->nullable();
            $table->string('email_empresa')->nullable();
            $table->string('nombre_padre')->nullable();
            $table->string('celular_padre')->nullable();
            $table->string('nombre_madre')->nullable();
            $table->string('celular_madre')->nullable();
            $table->string('nombre_tutor')->nullable();
            $table->string('celular_tutor')->nullable();    
            $table->string('nombre_pareja')->nullable();    
            $table->string('celular_pareja')->nullable();  
            $table->string('foto')->nullable();  
            $table->string('nit')->nullable();
            $table->string('razon_social_cliente')->nullable();
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
        Schema::dropIfExists('personas');
    }
}
