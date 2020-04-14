<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropSegundoTurnoToNotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notas', function (Blueprint $table) {
            $table->dropColumn('segundo_turno');
            //$table->decimal('segundo_turno', 8, 2)->nullable()->after('nota_total');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notas', function (Blueprint $table) {
            //$table->dropColumn('segundo_turno');
            $table->string('segundo_turno', 10)->nullable()->after('nota_total');
        });
    }
}
