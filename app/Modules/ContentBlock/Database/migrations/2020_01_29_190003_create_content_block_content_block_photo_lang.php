<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentBlockContentBlockPhotoLang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('content_blocks_photos_lang', function (Blueprint $table) {
			$table->increments('translation_id');
			$table->integer('photo_id')->unsigned();
			$table->char('locale', 2)->index();
			$table->string('title')->nullable();
			$table->string('description')->nullable();        
          
            $table->unique(['photo_id', 'locale']);
            $table->foreign('photo_id')->references('id')->on('content_blocks_photos')->onDelete('cascade');        
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('content_blocks_photos_lang');
    }
}
