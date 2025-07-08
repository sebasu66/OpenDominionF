<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStartDateInRounds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Adaptado para SQLite: sumar 72 horas a start_date
        DB::table('rounds')->update([
            'start_date' => DB::raw("datetime(start_date, '+72 hours')"),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Adaptado para SQLite: restar 72 horas a start_date
        DB::table('rounds')->update([
            'start_date' => DB::raw("datetime(start_date, '-72 hours')"),
        ]);
    }
}
