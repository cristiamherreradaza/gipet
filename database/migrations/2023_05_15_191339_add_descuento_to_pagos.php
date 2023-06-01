<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescuentoToPagos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pagos', function (Blueprint $table) {
            $table->decimal('descuento',10,2)->nullable()->after('a_pagar');
            $table->decimal('subTotal',10,2)->nullable()->after('importe');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pagos', function (Blueprint $table) {
            $table->dropColumn('descuento');
            $table->dropColumn('subTotal');
        });
    }
}
