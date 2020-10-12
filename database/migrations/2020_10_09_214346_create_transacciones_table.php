<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transacciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('codigo_anterior')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('servicio_id')->nullable();
            $table->foreign('servicio_id')->references('id')->on('servicios');
            $table->unsignedBigInteger('descuento_id')->nullable();
            $table->foreign('descuento_id')->references('id')->on('descuentos');
            $table->unsignedBigInteger('persona_id')->nullable();
            $table->foreign('persona_id')->references('id')->on('personas');
            $table->unsignedBigInteger('cobros_temporadas_id')->nullable();
            $table->foreign('cobros_temporadas_id')->references('id')->on('cobros_temporadas');
            $table->date('fecha_pago')->nullable();
            $table->decimal('estimado', 15, 2)->nullable();
            $table->decimal('a_pagar', 15, 2)->nullable();
            $table->decimal('pagado', 15, 2)->nullable();
            $table->decimal('saldo', 15, 2)->nullable();
            $table->string('observacion')->nullable();
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
        Schema::dropIfExists('transacciones');
    }
}
