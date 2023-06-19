<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCufdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cufd', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('codigo')->nullable();
            $table->string('codigoControl')->nullable();
            $table->string('direccion')->nullable();
            $table->timestamp('fechaVigencia')->nullable();
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
        Schema::dropIfExists('cufd');
    }
}
