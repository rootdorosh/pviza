<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentBlockContentBlock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('content_blocks', function (Blueprint $table) {
			$table->increments('id');
			$table->string('image')->nullable();
			$table->string('name');
			$table->boolean('is_active')->default('1');
			$table->boolean('is_hide_editor')->default('0');
			$table->json('adaptive_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('content_blocks');
    }
}
