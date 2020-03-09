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
            $table->string('a_paterno', 10);
            $table->string('a_materno', 10);
            $table->string('nombres', 120);
            $table->string('nomi', 5);
            $table->string('codID', 12);
            $table->integer('carnet');
            $table->string('ciu_d', 2);
            $table->string('tipo_usu', 10);
            $table->string('nom_usua', 30);
            $table->date('fec_incor');
            $table->enum('vig', ['N', 'S'])->default('S');
            $table->text('rol');
                        
            $table->date('fec_nac');
            $table->string('lug_nac', 60);
            $table->enum('sexo', ['O', 'F', 'M']);
            $table->enum('est_civil', ['O', 'B', 'D', 'C', 'S'])->default('S');
            $table->string('nom_cony', 50);
            $table->string('nom_hijo', 100);
            $table->string('direcc', 150);
            $table->string('zona', 30);
            $table->string('num_cel', 25);
            $table->string('num_fijo', 30);
            $table->string('email_d', 50);
            $table->string('foto', 200);
            $table->string('p_referencia', 60);
            $table->string('f_referencia', 30);
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
