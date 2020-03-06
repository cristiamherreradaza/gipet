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
            $table->string('a_paterno', 150);
            $table->string('a_materno', 150);
            $table->string('nombres', 100);
            $table->string('carnetIDA', 15);
            $table->string('ciu_a', 4);
            $table->date('fec_nac');
            $table->string('sexo', 1);
            $table->text('direc_a');
            $table->string('telf_fijo', 8);
            $table->string('telf_cel', 8);
            $table->string('email', 30);
            $table->string('trabaja', 1);
            $table->string('empresa', 80);
            $table->text('direc_emp');
            $table->string('telf_emp', 8);
            $table->string('fax', 8);
            $table->string('email_emp', 50);
            $table->string('nomb_pa', 150);
            $table->string('tel_pa', 10);
            $table->string('nom_ma', 150);
            $table->string('tel_ma', 10);
            $table->string('nom_tut', 150);
            $table->string('tel_tut', 10);
            $table->string('nom_esp', 150);
            $table->string('tel_esp', 10);
            //$table->integer('carreraID');
            //$table->integer('turnoID');
            $table->date('fec_ins');
            $table->string('insc', 2);
            $table->integer('gest_al');
            $table->string('raz_cli', 100);
            $table->string('nit', 50);
            $table->string('estado', 1);
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
