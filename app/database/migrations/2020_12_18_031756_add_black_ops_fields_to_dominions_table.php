<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBlackOpsFieldsToDominionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dominions', function (Blueprint $table) {
            $table->unsignedInteger('infamy')->after('morale')->default(0);
            $table->unsignedInteger('spy_resilience')->after('wizard_strength')->default(0);
            $table->unsignedInteger('wizard_resilience')->after('spy_resilience')->default(0);
        });

        Schema::table('dominion_tick', function (Blueprint $table) {
            $table->integer('infamy')->after('morale')->default(0);
            $table->integer('spy_resilience')->after('wizard_strength')->default(0);
            $table->integer('wizard_resilience')->after('spy_resilience')->default(0);
        });

        Schema::table('dominions', function (Blueprint $table) { $table->renameColumn('stat_spy_prestige', 'spy_mastery'); });
                Schema::table('dominions', function (Blueprint $table) { $table->renameColumn('stat_wizard_prestige', 'wizard_mastery'); });

        DB::table('daily_rankings')->where('key', 'spy-prestige')->update([
            'key' => 'spy-mastery'
        ]);

        DB::table('daily_rankings')->where('key', 'wizard-prestige')->update([
            'key' => 'wizard-mastery'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dominions', function (Blueprint $table) {
            $table->dropColumn('infamy');
            $table->dropColumn('spy_resilience');
            $table->dropColumn('wizard_resilience');
        });

        Schema::table('dominion_tick', function (Blueprint $table) {
            $table->dropColumn('infamy');
            $table->dropColumn('spy_resilience');
            $table->dropColumn('wizard_resilience');
        });

        Schema::table('dominions', function (Blueprint $table) { $table->renameColumn('spy_mastery', 'stat_spy_prestige'); });
        Schema::table('dominions', function (Blueprint $table) { $table->renameColumn('wizard_mastery', 'stat_wizard_prestige'); });

        DB::table('daily_rankings')->where('key', 'spy-mastery')->update([
            'key' => 'spy-prestige'
        ]);

        DB::table('daily_rankings')->where('key', 'wizard-mastery')->update([
            'key' => 'wizard-prestige'
        ]);
    }
}
