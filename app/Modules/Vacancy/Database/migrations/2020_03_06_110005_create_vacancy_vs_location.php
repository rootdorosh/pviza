<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacancyVsLocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('vacancy_vs_location', function (Blueprint $table) {
			$table->unsignedInteger('vacancy_id');
			$table->unsignedInteger('location_id');
			
			$table->foreign('vacancy_id')->references('id')->on('vacancy')->onDelete('CASCADE');
			$table->foreign('location_id')->references('id')->on('vacancy_locations')->onDelete('CASCADE');
			$table->primary(['vacancy_id', 'location_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('vacancy_vs_location');
    }
}
