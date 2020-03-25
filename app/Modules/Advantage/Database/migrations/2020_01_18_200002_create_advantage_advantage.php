<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvantageAdvantage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('advantage', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('category_id');
			$table->string('image')->nullable();
			$table->boolean('is_active')->default('1');
			$table->integer('rank')->default('10');
			$table->string('svg_code')->nullable();
			
			$table->foreign('category_id')->references('id')->on('advantage_categories')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('advantage');
    }
}
