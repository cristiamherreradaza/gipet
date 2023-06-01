<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddComplementoPersonas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('personas', function (Blueprint $table) {
            $table->string('complemento',10)->nullable()->after('cedula');
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
            $table->dropColumn('complemento');
        });
    }
}
