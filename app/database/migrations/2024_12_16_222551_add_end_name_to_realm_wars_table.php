<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEndNameToRealmWarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // SQLite: solo se permite un drop/rename por transacción, así que separamos las operaciones
        Schema::table('realm_wars', function (Blueprint $table) {
            $table->string('source_realm_name_end')->nullable()->after('source_realm_name');
        });
        Schema::table('realm_wars', function (Blueprint $table) {
            $table->string('target_realm_name_end')->nullable()->after('target_realm_name');
        });
        Schema::table('realm_wars', function (Blueprint $table) {
            $table->renameColumn('source_realm_name', 'source_realm_name_start');
        });
        Schema::table('realm_wars', function (Blueprint $table) {
            $table->renameColumn('target_realm_name', 'target_realm_name_start');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // SQLite: solo se permite un drop/rename por transacción, así que separamos las operaciones
        Schema::table('realm_wars', function (Blueprint $table) {
            $table->renameColumn('source_realm_name_start', 'source_realm_name');
        });
        Schema::table('realm_wars', function (Blueprint $table) {
            $table->renameColumn('target_realm_name_start', 'target_realm_name');
        });
        Schema::table('realm_wars', function (Blueprint $table) {
            $table->dropColumn('source_realm_name_end');
        });
        Schema::table('realm_wars', function (Blueprint $table) {
            $table->dropColumn('target_realm_name_end');
        });
    }
}
