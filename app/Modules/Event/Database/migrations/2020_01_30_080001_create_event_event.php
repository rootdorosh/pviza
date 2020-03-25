<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventEvent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('event', function (Blueprint $table) {
			$table->increments('id');
			$table->string('event_id')->nullable();
			$table->tinyInteger('content_type');
			$table->boolean('is_active')->default('1');
			$table->string('from_email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('event');
    }
}
