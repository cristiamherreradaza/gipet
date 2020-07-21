<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedAtToPrerequisitosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prerequisitos', function (Blueprint $table) {
            $table->dropColumn('borrado');
            $table->datetime('deleted_at')->nullable()->after('estado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prerequisitos', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
            $table->datetime('borrado')->nullable()->after('estado');
        });
    }
}
