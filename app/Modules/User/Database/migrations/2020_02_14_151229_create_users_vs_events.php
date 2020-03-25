<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersVsEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_vs_events', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('event_id');
            $table->primary(['user_id', 'event_id']);
            $table->foreign('user_id', 'users_vs_events_user_id')->references('id')->on('users');
            $table->foreign('event_id', 'users_vs_events_event_id')->references('id')->on('event');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_vs_events');
    }
}
