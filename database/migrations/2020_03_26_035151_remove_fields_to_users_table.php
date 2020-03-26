<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //$table->renameColumn('name', 'username');
            $table->dropColumn('name');
            $table->dropColumn('email');
            $table->dropColumn('email_verified_at');
            $table->dropColumn('remember_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //$table->renameColumn('username','name');            
            $table->rememberToken()->after('id');
            $table->timestamp('email_verified_at')->nullable()->after('id');
            $table->string('email')->nullable()->after('id');
            $table->string('name')->nullable()->after('id');
        });
    }
}
