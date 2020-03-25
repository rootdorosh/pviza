<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentBlockContentBlockLang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('content_blocks_lang', function (Blueprint $table) {
			$table->increments('translation_id');
			$table->integer('content_block_id')->unsigned();
			$table->char('locale', 2)->index();
			$table->string('title')->nullable();
			$table->longText('body')->nullable();        
          
            $table->unique(['content_block_id', 'locale']);
            $table->foreign('content_block_id')->references('id')->on('content_blocks')->onDelete('cascade');        
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('content_blocks_lang');
    }
}
