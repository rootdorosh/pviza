<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('domain_id');
			$table->string('title');
			$table->boolean('is_active')->nullable()->default('1');
			$table->boolean('is_sitemap')->nullable()->default('0');
			$table->text('items')->nullable();
			
			$table->foreign('domain_id')->references('id')->on('structure_domains')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('menu');
    }
}
