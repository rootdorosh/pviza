<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventEventLang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('event_lang', function (Blueprint $table) {
			$table->increments('translation_id');
			$table->integer('event_id')->unsigned();
			$table->char('locale', 2)->index();
			$table->string('subject')->nullable();
			$table->string('from_name')->nullable();
			$table->string('body')->nullable();        
          
            $table->unique(['event_id', 'locale']);
            $table->foreign('event_id')->references('id')->on('event')->onDelete('cascade');        
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('event_lang');
    }
}
