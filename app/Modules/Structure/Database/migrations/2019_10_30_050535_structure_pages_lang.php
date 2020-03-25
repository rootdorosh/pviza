<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StructurePagesLang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('structure_pages_lang', function (Blueprint $table) {
            $table->increments('translation_id');
            $table->integer('page_id')->unsigned();
            $table->char('locale', 2)->index();
            $table->string('seo_title');
            $table->string('seo_h1')->nullable();
            $table->string('seo_description')->nullable();
            $table->string('breacrumbs_title')->nullable();
            $table->mediumText('head')->nullable();
            
            $table->unique(['page_id','locale']);
            $table->foreign('page_id')->references('id')->on('structure_pages')->onDelete('cascade');        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {       
        Schema::dropIfExists('structure_pages_lang');
    }
}
