<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacancyVacancy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('vacancy', function (Blueprint $table) {
			$table->increments('id');
			$table->boolean('is_active')->default('1');
			$table->boolean('is_popular')->default('1');
			$table->integer('rank')->default('10');
			$table->string('date_posted')->nullable();
			$table->string('hiring_organization')->nullable();
			$table->string('image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('vacancy');
    }
}
