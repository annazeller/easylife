<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEventinfoToTodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('todos', function (Blueprint $table) {
            $table->string('calendar_id')->nullable();
            $table->string('event_id')->nullable();;
            $table->datetime('datetime_start')->nullable();;
            $table->datetime('datetime_end')->nullable();;
            $table->tinyInteger('completed')->default(0);
            $table->boolean('scheduled')->default(false);
            $table->string('transparency')->default('opaque');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('todos', function (Blueprint $table) {
            $table->dropColumn('calendar_id');
            $table->dropColumn('event_id');
            $table->dropColumn('datetime_start');
            $table->dropColumn('datetime_end');
            $table->dropColumn('completed');
            $table->dropColumn('scheduled');
            $table->dropColumn('transparency');
        });
    }
}
