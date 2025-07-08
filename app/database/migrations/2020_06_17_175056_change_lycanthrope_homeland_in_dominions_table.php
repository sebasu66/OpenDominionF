<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeLycanthropeHomelandInDominionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $race_id = DB::table('races')->where('name', 'Lycanthrope')->pluck('id')->first();
        if ($race_id !== null) {
            // Adaptado para SQLite: usar expresiones aritméticas válidas
            $dominions = DB::table('dominions')->where('race_id', $race_id)->get();
            foreach ($dominions as $dominion) {
                DB::table('dominions')->where('id', $dominion->id)->update([
                    'land_cavern' => $dominion->land_cavern - $dominion->building_home,
                    'land_forest' => $dominion->land_forest + $dominion->building_home
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $race_id = DB::table('races')->where('name', 'Lycanthrope')->pluck('id')->first();
        if ($race_id !== null) {
            $dominions = DB::table('dominions')->where('race_id', $race_id)->get();
            foreach ($dominions as $dominion) {
                DB::table('dominions')->where('id', $dominion->id)->update([
                    'land_forest' => $dominion->land_forest - $dominion->building_home,
                    'land_cavern' => $dominion->land_cavern + $dominion->building_home
                ]);
            }
        }
    }
}
