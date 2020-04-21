<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameFieldsToNotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notas', function (Blueprint $table) {
            $table->renameColumn('gestion', 'anio_vigente');
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
            $table->renameColumn('anio_vigente', 'gestion');
        });
    }
}
