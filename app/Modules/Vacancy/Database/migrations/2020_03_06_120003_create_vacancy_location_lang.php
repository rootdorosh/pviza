<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacancyLocationLang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('vacancy_locations_lang', function (Blueprint $table) {
			$table->increments('translation_id');
			$table->integer('category_id')->unsigned();
			$table->char('locale', 2)->index();
			$table->string('title')->nullable();
			$table->string('alias')->nullable();
			$table->string('description')->nullable();
			$table->string('seo_h1')->nullable();
			$table->string('seo_title')->nullable();
			$table->string('seo_description')->nullable();        
          
            $table->unique(['category_id', 'locale']);
            $table->foreign('category_id')->references('id')->on('vacancy_locations')->onDelete('cascade');        
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('vacancy_locations_lang');
    }
}
