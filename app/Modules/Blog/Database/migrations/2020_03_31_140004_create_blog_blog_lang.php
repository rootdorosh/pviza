<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogBlogLang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('blog_lang', function (Blueprint $table) {
			$table->increments('translation_id');
			$table->integer('blog_id')->unsigned();
			$table->char('locale', 2)->index();
			$table->string('title')->nullable();
			$table->string('alias')->nullable();
			$table->string('description')->nullable();
			$table->string('seo_h1')->nullable();
			$table->string('seo_title')->nullable();
			$table->string('seo_description')->nullable();        
          
            $table->unique(['blog_id', 'locale']);
            $table->foreign('blog_id')->references('id')->on('blog')->onDelete('cascade');        
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('blog_lang');
    }
}
