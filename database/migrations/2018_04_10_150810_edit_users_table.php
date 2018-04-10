<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('sleephours');
            $table->integer('morningTime');
            $table->integer('eveningTime');
            $table->time('workingBegin');
            $table->integer('workingHours');
            $table->integer('breakfast');
            $table->integer('dinner');
            $table->integer('drive');
            $table->time('dinnertime');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('sleephours');
            $table->dropColumn('morningTime');
            $table->dropColumn('eveningTime');
            $table->dropColumn('workingBegin');
            $table->dropColumn('workingHours');
            $table->dropColumn('breakfast');
            $table->dropColumn('dinner');
            $table->dropColumn('drive');
            $table->dropColumn('dinnertime');

        });
    }
}
