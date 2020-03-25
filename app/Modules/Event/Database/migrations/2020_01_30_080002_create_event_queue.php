<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventQueue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('event_queue', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('event_id');
			$table->tinyInteger('status');
			$table->string('from_email')->nullable();
			$table->string('from_name')->nullable();
			$table->string('email_to')->nullable();
			$table->string('subject')->nullable();
			$table->longText('body')->nullable();
			$table->integer('created_time');
			$table->integer('sended_time')->nullable();
			$table->text('files')->nullable();
			
			$table->foreign('event_id')->references('id')->on('event')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('event_queue');
    }
}
