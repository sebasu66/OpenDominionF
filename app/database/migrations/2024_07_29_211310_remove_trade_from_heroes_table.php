<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveTradeFromHeroesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Adaptado para SQLite: copiar el valor de la columna trade a class usando PHP
        $heroes = DB::table('heroes')->get();
        foreach ($heroes as $hero) {
            DB::table('heroes')->where('id', $hero->id)->update(['class' => $hero->trade]);
        }

        Schema::table('heroes', function (Blueprint $table) {
            $table->dropColumn('trade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('heroes', function (Blueprint $table) {
            $table->string('trade')->after('class')->nullable();
        });

        // Adaptado para SQLite: copiar el valor de la columna class a trade usando PHP
        $heroes = DB::table('heroes')->get();
        foreach ($heroes as $hero) {
            DB::table('heroes')->where('id', $hero->id)->update(['trade' => $hero->class]);
        }
        DB::table('heroes')->update(['class' => 'warrior']);
    }
}
