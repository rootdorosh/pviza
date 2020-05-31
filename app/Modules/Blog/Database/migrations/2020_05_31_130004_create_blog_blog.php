<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogBlog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('blog', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('category_id');
			$table->boolean('is_active')->default('1');
			$table->boolean('is_home')->default('1');
			$table->string('image')->nullable();
			$table->string('image_header')->nullable();
			$table->integer('created_at');
			
			$table->foreign('category_id')->references('id')->on('blog_categories')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('blog');
    }
}
