<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewReview extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('review', function (Blueprint $table) {
			$table->increments('id');
			$table->boolean('is_active')->default('1');
			$table->boolean('is_home')->default('1');
			$table->integer('created_at');
			$table->string('name');
			$table->string('email')->nullable();
			$table->longText('comment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('review');
    }
}
