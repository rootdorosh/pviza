<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StructureDomainsLang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('structure_domains_lang', function (Blueprint $table) {
            $table->increments('translation_id');
            $table->integer('domain_id')->unsigned();
            $table->char('locale', 2)->index();
            $table->string('copyright')->nullable();
            
            $table->unique(['domain_id','locale']);
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
        Schema::dropIfExists('structure_domains_lang');
    }
}
