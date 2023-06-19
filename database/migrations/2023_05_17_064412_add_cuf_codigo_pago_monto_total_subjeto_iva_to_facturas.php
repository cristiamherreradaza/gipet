<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCufCodigoPagoMontoTotalSubjetoIvaToFacturas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facturas', function (Blueprint $table) {
            $table->string('cuf')->nullable()->after('anio_vigente');
            $table->string('codigo_metodo_pago_siat',10)->nullable()->after('cuf');
            $table->decimal('monto_total_subjeto_iva',10,2)->nullable()->after('codigo_metodo_pago_siat');
            $table->decimal('descuento_adicional',10,2)->nullable()->after('monto_total_subjeto_iva');
            $table->text('productos_xml')->nullable()->after('descuento_adicional');
            $table->string('codigo_descripcion')->nullable()->after('productos_xml');
            $table->string('codigo_recepcion')->nullable()->after('codigo_descripcion');
            $table->string('codigo_trancaccion')->nullable()->after('codigo_recepcion');
            $table->text('descripcion')->nullable()->after('codigo_trancaccion');
            $table->string('cuis')->nullable()->after('descripcion');
            $table->string('cufd')->nullable()->after('cuis');
            $table->dateTime('fechaVigencia')->nullable()->after('cufd');
            $table->string('tipo_factura')->nullable()->after('fechaVigencia');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('facturas', function (Blueprint $table) {
            $table->dropColumn('cuf');
            $table->dropColumn('codigo_metodo_pago_siat');
            $table->dropColumn('monto_total_subjeto_iva');
            $table->dropColumn('descuento_adicional');
            $table->dropColumn('productos_xml');
            $table->dropColumn('codigo_descripcion');
            $table->dropColumn('codigo_recepcion');
            $table->dropColumn('codigo_trancaccion');
            $table->dropColumn('descripcion');
            $table->dropColumn('cuis');
            $table->dropColumn('cufd');
            $table->dropColumn('fechaVigencia');
            $table->dropColumn('tipo_factura');
        });
    }
}
