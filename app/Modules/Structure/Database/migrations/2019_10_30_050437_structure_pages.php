<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StructurePages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('structure_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('domain_id')->unsigned();
            $table->string('structure_id')->unique();
            $table->string('alias');
            $table->string('body_class')->nullable();
            $table->integer('template_id')->unsigned();
            $table->boolean('is_search')->default(1);
            $table->boolean('is_canonical')->default(0);
            $table->boolean('is_breadcrumbs')->default(1);
            $table->boolean('is_menu')->default(1);
            
            $table->foreign('domain_id')->references('id')->on('structure_domains')->onDelete('cascade');        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('structure_pages');
    }
}
