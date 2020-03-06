<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogoCuentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogo_cuentas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo', 30);
            $table->string('descripcion', 200);
            $table->integer('moneda');
            $table->integer('grupo');
            $table->integer('codadm');
            $table->integer('codserv');
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
        Schema::dropIfExists('catalogo_cuentas');
    }
}
