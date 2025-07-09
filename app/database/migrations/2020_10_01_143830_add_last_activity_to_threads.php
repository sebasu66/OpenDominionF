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
        Schema::table('council_threads', function (Blueprint $table) {
            $table->dateTime('last_activity')->nullable()->after('body');
        });

        // Set last activity to created date
        DB::table('council_threads')
            ->update(['last_activity' => DB::raw('CAST(created_at AS datetime)')]);

        // Set last activity to latest post created date (SQLite compatible)
        DB::statement('
            UPDATE council_threads
            SET last_activity = (
                SELECT MAX(created_at)
                FROM council_posts
                WHERE council_posts.council_thread_id = council_threads.id
            )
            WHERE EXISTS (
                SELECT 1
                FROM council_posts
                WHERE council_posts.council_thread_id = council_threads.id
            )
        ');

        Schema::table('forum_threads', function (Blueprint $table) {
            $table->dateTime('last_activity')->nullable()->after('body');
        });

        // Set last activity to created date
        DB::table('forum_threads')
            ->update(['last_activity' => DB::raw('CAST(created_at AS datetime)')]);

        // Set last activity to latest post created date (SQLite compatible)
        DB::statement('
            UPDATE forum_threads
            SET last_activity = (
                SELECT MAX(created_at)
                FROM forum_posts
                WHERE forum_posts.forum_thread_id = forum_threads.id
            )
            WHERE EXISTS (
                SELECT 1
                FROM forum_posts
                WHERE forum_posts.forum_thread_id = forum_threads.id
            )
        ');

        Schema::table('message_board_threads', function (Blueprint $table) {
            $table->dateTime('last_activity')->nullable()->after('body');
        });

        // Set last activity to created date
        DB::table('message_board_threads')
            ->update(['last_activity' => DB::raw('CAST(created_at AS datetime)')]);

        // Set last activity to latest post created date (SQLite compatible)
        DB::statement('
            UPDATE message_board_threads
            SET last_activity = (
                SELECT MAX(created_at)
                FROM message_board_posts
                WHERE message_board_posts.message_board_thread_id = message_board_threads.id
            )
            WHERE EXISTS (
                SELECT 1
                FROM message_board_posts
                WHERE message_board_posts.message_board_thread_id = message_board_threads.id
            )
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('council_threads', function (Blueprint $table) {
            $table->dropColumn('last_activity');
        });

        Schema::table('forum_threads', function (Blueprint $table) {
            $table->dropColumn('last_activity');
        });

        Schema::table('message_board_threads', function (Blueprint $table) {
            $table->dropColumn('last_activity');
        });
    }
}
