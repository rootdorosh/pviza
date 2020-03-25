<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacancyVsCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('vacancy_vs_category', function (Blueprint $table) {
			$table->unsignedInteger('vacancy_id');
			$table->unsignedInteger('category_id');
			
			$table->foreign('vacancy_id')->references('id')->on('vacancy')->onDelete('CASCADE');
			$table->foreign('category_id')->references('id')->on('vacancy_categories')->onDelete('CASCADE');
			$table->primary(['vacancy_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('vacancy_vs_category');
    }
}
