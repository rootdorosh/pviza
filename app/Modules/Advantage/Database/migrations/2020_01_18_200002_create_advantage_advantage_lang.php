<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvantageAdvantageLang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('advantage_lang', function (Blueprint $table) {
			$table->increments('translation_id');
			$table->integer('advantage_id')->unsigned();
			$table->char('locale', 2)->index();
			$table->string('title')->nullable();
			$table->text('description')->nullable();
			$table->mediumText('body')->nullable();        
          
            $table->unique(['advantage_id', 'locale']);
            $table->foreign('advantage_id')->references('id')->on('advantage')->onDelete('cascade');        
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('advantage_lang');
    }
}
