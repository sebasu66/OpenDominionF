<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLastActivityToThreads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // La columna ya existe en council_threads, así que no la agregamos de nuevo
        // Schema::table('council_threads', function (Blueprint $table) {
        //     $table->dateTime('last_activity')->nullable()->after('body');
        // });

        // Set last activity to created date
        DB::table('council_threads')
            ->update(['last_activity' => DB::raw('CAST(created_at AS datetime)')]);

        // El siguiente bloque no es compatible con SQLite, así que lo comentamos
        /*
        // Get latest posts
        $subquery = DB::table('council_posts')
            ->select(DB::raw('council_thread_id, MAX(created_at) AS post_created_at'))
            ->groupBy('council_thread_id');

        // Set last activity to latest post created date
        DB::table('council_threads')
            ->joinSub($subquery, 'latest_posts', function ($join) {
                $join->on('council_threads.id', '=', 'latest_posts.council_thread_id');
            })->update([
                'council_threads.last_activity' => DB::raw('CAST(latest_posts.post_created_at AS datetime)')
            ]);
        */

        // La columna ya existe en forum_threads, así que no la agregamos de nuevo
        // Schema::table('forum_threads', function (Blueprint $table) {
        //     $table->dateTime('last_activity')->nullable()->after('body');
        // });

        // Set last activity to created date
        DB::table('forum_threads')
            ->update(['last_activity' => DB::raw('CAST(created_at AS datetime)')]);

        // Get latest posts
        // $subquery = DB::table('forum_posts')
        //     ->select(DB::raw('forum_thread_id, MAX(created_at) AS post_created_at'))
        //     ->groupBy('forum_thread_id');

        // Set last activity to latest post created date
        // DB::table('forum_threads')
        //     ->joinSub($subquery, 'latest_posts', function ($join) {
        //         $join->on('forum_threads.id', '=', 'latest_posts.forum_thread_id');
        //     })->update([
        //         'forum_threads.last_activity' => DB::raw('CAST(latest_posts.post_created_at AS datetime)')
        //     ]);

        // La columna ya existe en message_board_threads, así que no la agregamos de nuevo
        // Schema::table('message_board_threads', function (Blueprint $table) {
        //     $table->dateTime('last_activity')->nullable()->after('body');
        // });

        // Set last activity to created date
        DB::table('message_board_threads')
            ->update(['last_activity' => DB::raw('CAST(created_at AS datetime)')]);

        // Get latest posts
        // $subquery = DB::table('message_board_posts')
        //     ->select(DB::raw('message_board_thread_id, MAX(created_at) AS post_created_at'))
        //     ->groupBy('message_board_thread_id');

        // Set last activity to latest post created date
        // DB::table('message_board_threads')
        //     ->joinSub($subquery, 'latest_posts', function ($join) {
        //         $join->on('message_board_threads.id', '=', 'latest_posts.message_board_thread_id');
        //     })->update([
        //         'message_board_threads.last_activity' => DB::raw('CAST(latest_posts.post_created_at AS datetime)')
        //     ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // La columna ya existe en council_threads, así que este dropColumn puede fallar si ya fue eliminada
        // Schema::table('council_threads', function (Blueprint $table) {
        //     $table->dropColumn('last_activity');
        // });

        // La columna ya existe en forum_threads, así que este dropColumn puede fallar si ya fue eliminada
        // Schema::table('forum_threads', function (Blueprint $table) {
        //     $table->dropColumn('last_activity');
        // });

        // La columna ya existe en message_board_threads, así que este dropColumn puede fallar si ya fue eliminada
        // Schema::table('message_board_threads', function (Blueprint $table) {
        //     $table->dropColumn('last_activity');
        // });
    }
}
