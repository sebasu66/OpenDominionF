<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserAgentToDominionHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dominion_history', function (Blueprint $table) {
            $table->string('ip')->after('delta')->nullable();
            $table->string('device')->after('ip')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dominion_history', function (Blueprint $table) {
            $table->dropColumn('ip');
            $table->dropColumn('device');
        });
    }
}
