<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserPasswordToPersonas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('personas', function (Blueprint $table) {
            $table->datetime('fecha_modificacion')->nullable()->after('estado');
            $table->string('usuario')->after('fecha_modificacion')->nullable();
            $table->string('password')->after('usuario')->nullable();
            $table->string('cantidad_intentos')->after('password')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('personas', function (Blueprint $table) {
            $table->dropColumn('fecha_modificacion');
            $table->dropColumn('usuario');
            $table->dropColumn('password');
            $table->dropColumn('cantidad_intentos');
        });
    }
}
