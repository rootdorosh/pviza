<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentBlockContentBlockPhoto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('content_blocks_photos', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('content_block_id');
			$table->string('image')->nullable();
			$table->boolean('is_active')->default('1');
			$table->tinyInteger('type')->nullable();
			$table->integer('rank')->default('10');
			
			$table->foreign('content_block_id')->references('id')->on('content_blocks')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('content_blocks_photos');
    }
}
