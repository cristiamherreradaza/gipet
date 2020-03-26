<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nomina', 5)->nullable()->after('id');
            $table->string('nombres', 120)->nullable()->after('id');
            $table->string('apellido_materno', 20)->nullable()->after('id');
            $table->string('apellido_paterno', 20)->nullable()->after('id');
            $table->integer('codigo_anterior')->nullable()->after('id');
            $table->datetime('borrado', 0)->nullable()->after('password');
            $table->string('estado', 15)->nullable()->after('password');
            $table->string('name')->nullable()->after('password');
            $table->string('numero_referencia', 30)->nullable()->after('password');
            $table->string('persona_referencia', 60)->nullable()->after('password');
            $table->string('foto', 200)->nullable()->after('password');
            $table->string('email', 60)->nullable()->after('password');
            $table->string('numero_fijo', 30)->nullable()->after('password');
            $table->string('numero_celular', 25)->nullable()->after('password');
            $table->string('zona', 30)->nullable()->after('password');
            $table->string('direccion', 150)->nullable()->after('password');
            $table->string('nombre_hijo', 100)->nullable()->after('password');
            $table->string('nombre_conyugue', 50)->nullable()->after('password');
            $table->string('estado_civil', 20)->nullable()->after('password');
            $table->string('sexo',20)->nullable()->after('password');
            $table->string('lugar_nacimiento', 60)->nullable()->after('password');
            $table->date('fecha_nacimiento')->nullable()->after('password');
            $table->text('rol')->nullable()->after('password');
            $table->string('vigente', 10)->nullable()->after('password');
            $table->date('fecha_incorporacion')->nullable()->after('password');
            $table->string('nombre_usuario', 30)->nullable()->after('password');
            $table->string('tipo_usuario', 10)->nullable()->after('password');
            $table->string('expedido', 20)->nullable()->after('password');
            $table->string('cedula', 20)->nullable()->after('password');
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
            $table->dropColumn('nomina');
            $table->dropColumn('nombres');
            $table->dropColumn('apellido_materno');
            $table->dropColumn('apellido_paterno');
            $table->dropColumn('codigo_anterior');
            $table->dropColumn('borrado');
            $table->dropColumn('estado');
            $table->dropColumn('name');
            $table->dropColumn('numero_referencia');
            $table->dropColumn('persona_referencia');
            $table->dropColumn('foto');
            $table->dropColumn('email');
            $table->dropColumn('numero_fijo');
            $table->dropColumn('numero_celular');
            $table->dropColumn('zona');
            $table->dropColumn('direccion');
            $table->dropColumn('nombre_hijo');
            $table->dropColumn('nombre_conyugue');
            $table->dropColumn('estado_civil');
            $table->dropColumn('sexo');
            $table->dropColumn('lugar_nacimiento');
            $table->dropColumn('fecha_nacimiento');
            $table->dropColumn('rol');
            $table->dropColumn('vigente');
            $table->dropColumn('fecha_incorporacion');
            $table->dropColumn('nombre_usuario');
            $table->dropColumn('tipo_usuario');
            $table->dropColumn('expedido');
            $table->dropColumn('cedula');
        });
    }
}
