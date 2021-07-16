<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('codigo_anterior')->nullable();
            // para crear una llave foranea
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            // fin creacion de la llave foranea
            $table->unsignedBigInteger('persona_id')->nullable();
            $table->foreign('persona_id')->references('id')->on('personas');
            $table->unsignedBigInteger('servicio_id')->nullable();
            $table->foreign('servicio_id')->references('id')->on('servicios');
            $table->unsignedBigInteger('tipo_mensualidad_id')->nullable();
            $table->foreign('tipo_mensualidad_id')->references('id')->on('tipos_mensualidades');
            $table->unsignedBigInteger('descuento_persona_id')->nullable();
            $table->foreign('descuento_persona_id')->references('id')->on('descuentos_personas');
            $table->decimal('a_pagar', 15, 2)->nullable();
            $table->decimal('importe', 15, 2)->nullable();
            $table->decimal('faltante', 15, 2)->nullable();
            $table->decimal('total', 15, 2)->nullable();
            $table->integer('mensualidad')->nullable();
            $table->date('fecha')->nullable();
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
        Schema::dropIfExists('pagos');
    }
}
