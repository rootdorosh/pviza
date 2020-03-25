<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacancyVsType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('vacancy_vs_type', function (Blueprint $table) {
			$table->unsignedInteger('vacancy_id');
			$table->unsignedInteger('type_id');
			
			$table->foreign('vacancy_id')->references('id')->on('vacancy')->onDelete('CASCADE');
			$table->foreign('type_id')->references('id')->on('vacancy_types')->onDelete('CASCADE');
			$table->primary(['vacancy_id', 'type_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('vacancy_vs_type');
    }
}
