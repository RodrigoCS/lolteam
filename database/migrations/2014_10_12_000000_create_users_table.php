<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('lastname');
            $table->date('birthday');
            $table->string('country');
            $table->string('city');
            $table->string('timezone');
            $table->string('email')->unique();
            $table->string('summoner');
            $table->string('region');
            $table->string('position');
            $table->string('password');
            $table->string('facebook');
            $table->string('twitter');
            $table->string('youtube');
            $table->string('twitch');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
