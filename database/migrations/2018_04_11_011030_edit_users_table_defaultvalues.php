<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditUsersTableDefaultvalues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('sleephours')->nullable()->change();
            $table->integer('morningTime')->nullable()->change();
            $table->integer('eveningTime')->nullable()->change();
            $table->time('workingBegin')->nullable()->change();
            $table->integer('workingHours')->nullable()->change();
            $table->integer('breakfast')->nullable()->change();
            $table->integer('dinner')->nullable()->change();
            $table->integer('drive')->nullable()->change();
            $table->time('dinnertime')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
