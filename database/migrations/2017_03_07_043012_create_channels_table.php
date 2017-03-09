<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('channel_name');
            $table->string('alias_name');
            $table->integer('sender_id');
            $table->foreign('sender_id')->references('id')->on('users');
            $table->integer('receiver_id');
            $table->foreign('receiver_id')->references('id')->on('users');
            $table->string('sender_status');
            $table->string('receiver_status');
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
        Schema::drop('channels');
    }
}
