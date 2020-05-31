<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResumeResume extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('resume', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('vacancy_id')->nullable();
			$table->integer('created_at');
			$table->string('name')->nullable();
			$table->string('email')->nullable();
			$table->string('phone')->nullable();
			$table->text('message')->nullable();
			$table->string('document')->nullable();
			
			$table->foreign('vacancy_id')->references('id')->on('vacancy')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('resume');
    }
}
