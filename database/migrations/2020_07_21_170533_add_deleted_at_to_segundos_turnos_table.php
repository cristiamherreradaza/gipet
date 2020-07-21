<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedAtToSegundosTurnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('segundos_turnos', function (Blueprint $table) {
            $table->datetime('deleted_at')->nullable()->after('validado');
            $table->string('estado', 30)->nullable()->after('validado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('segundos_turnos', function (Blueprint $table) {
            $table->dropColumn('estado');
            $table->dropColumn('deleted_at');
        });
    }
}
