<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacancyType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('vacancy_types', function (Blueprint $table) {
			$table->increments('id');
			$table->boolean('is_active')->default('1');
			$table->integer('rank')->default('10');
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
        Schema::dropIfExists('vacancy_types');
    }
}
