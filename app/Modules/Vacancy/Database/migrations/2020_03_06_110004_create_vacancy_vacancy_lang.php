<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacancyVacancyLang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('vacancy_lang', function (Blueprint $table) {
			$table->increments('translation_id');
			$table->integer('vacancy_id')->unsigned();
			$table->char('locale', 2)->index();
			$table->string('title')->nullable();
			$table->string('alias')->nullable();
			$table->string('salary')->nullable();
			$table->string('work_schedule')->nullable();
			$table->string('contract_type')->nullable();
			$table->string('description')->nullable();
			$table->string('seo_h1')->nullable();
			$table->string('seo_title')->nullable();
			$table->string('seo_description')->nullable();        
          
            $table->unique(['vacancy_id', 'locale']);
            $table->foreign('vacancy_id')->references('id')->on('vacancy')->onDelete('cascade');        
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('vacancy_lang');
    }
}
