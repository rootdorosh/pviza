<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvantageCategoryLang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('advantage_categories_lang', function (Blueprint $table) {
			$table->increments('translation_id');
			$table->integer('category_id')->unsigned();
			$table->char('locale', 2)->index();
			$table->string('title')->nullable();
			$table->string('description')->nullable();        
          
            $table->unique(['category_id', 'locale']);
            $table->foreign('category_id')->references('id')->on('advantage_categories')->onDelete('cascade');        
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('advantage_categories_lang');
    }
}
