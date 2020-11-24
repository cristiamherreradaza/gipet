<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNumeroImportacionToCarrerasPersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carreras_personas', function (Blueprint $table) {
            $table->integer('numero_importacion')->nullable()->after('vigencia');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carreras_personas', function (Blueprint $table) {
            $table->dropColumn('numero_importacion');
        });
    }
}
