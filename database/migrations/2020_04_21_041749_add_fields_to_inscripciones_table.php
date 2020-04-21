<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToInscripcionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inscripciones', function (Blueprint $table) {
            $table->decimal('nota', 8, 2)->nullable()->default(0)->after('fecha_inscripcion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inscripciones', function (Blueprint $table) {
            $table->dropColumn('nota');
        });
    }
}
