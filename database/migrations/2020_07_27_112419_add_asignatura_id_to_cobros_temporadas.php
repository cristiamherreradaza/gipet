<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAsignaturaIdToCobrosTemporadas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cobros_temporadas', function (Blueprint $table) {
            $table->integer('asignatura_id')->nullable()->after('carrera_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cobros_temporadas', function (Blueprint $table) {
            $table->dropColumn('asignatura_id');
        });
    }
}
