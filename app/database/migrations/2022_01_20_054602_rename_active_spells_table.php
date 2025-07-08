<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class RenameActiveSpellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Solo ejecutar si la tabla active_spells existe
        if (Schema::hasTable('active_spells')) {
            // Eliminar todos los registros (opcional, según lógica original)
            DB::table('active_spells')->delete();

            // Renombrar la tabla original a un nombre temporal
            Schema::rename('active_spells', 'active_spells_old');

            // Crear la nueva tabla con la estructura deseada (sin las foreign keys antiguas y con spell_id)
            Schema::create('dominion_spells', function (Blueprint $table) {
                $table->unsignedInteger('dominion_id');
                $table->unsignedInteger('spell_id');
                $table->unsignedInteger('cast_by_dominion_id')->nullable();
                $table->integer('duration');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->primary(['dominion_id', 'spell_id']);
                $table->foreign('spell_id')->references('id')->on('spells');
                $table->foreign('dominion_id')->references('id')->on('dominions');
                $table->foreign('cast_by_dominion_id')->references('id')->on('dominions');
            });

            // Copiar los datos de la tabla antigua a la nueva (requiere mapear spell a spell_id)
            // NOTA: Este paso asume que el valor de 'spell' en active_spells_old coincide con el nombre en la tabla spells
            DB::statement('INSERT INTO dominion_spells (dominion_id, spell_id, cast_by_dominion_id, duration, created_at, updated_at)
                SELECT a.dominion_id, s.id, a.cast_by_dominion_id, a.duration, a.created_at, a.updated_at
                FROM active_spells_old a
                JOIN spells s ON s.name = a.spell');

            // Eliminar la tabla temporal
            Schema::drop('active_spells_old');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Solo ejecutar si la tabla dominion_spells existe
        if (Schema::hasTable('dominion_spells')) {
            // Eliminar todos los registros (opcional, según lógica original)
            DB::table('dominion_spells')->delete();

            // Renombrar la tabla actual a un nombre temporal
            Schema::rename('dominion_spells', 'dominion_spells_old');

            // Crear la tabla original con la estructura anterior
            Schema::create('active_spells', function (Blueprint $table) {
                $table->unsignedInteger('dominion_id');
                $table->string('spell');
                $table->unsignedInteger('cast_by_dominion_id')->nullable();
                $table->integer('duration');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->primary(['dominion_id', 'spell']);
                $table->foreign('dominion_id')->references('id')->on('dominions');
                $table->foreign('cast_by_dominion_id')->references('id')->on('dominions');
            });

            // Copiar los datos de la tabla temporal a la original (requiere mapear spell_id a spell)
            // NOTA: Este paso asume que el id de spell en dominion_spells_old existe en la tabla spells
            DB::statement('INSERT INTO active_spells (dominion_id, spell, cast_by_dominion_id, duration, created_at, updated_at)
                SELECT d.dominion_id, s.name, d.cast_by_dominion_id, d.duration, d.created_at, d.updated_at
                FROM dominion_spells_old d
                JOIN spells s ON s.id = d.spell_id');

            // Eliminar la tabla temporal
            Schema::drop('dominion_spells_old');
        }
    }
}
