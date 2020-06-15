<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackFeedback extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name')->nullable();
			$table->string('email')->nullable();
			$table->string('phone')->nullable();
			$table->text('message')->nullable();
			$table->integer('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('feedback');
    }
}
