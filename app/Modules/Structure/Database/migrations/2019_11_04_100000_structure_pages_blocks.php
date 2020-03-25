<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StructurePagesBlocks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('structure_pages_blocks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('page_id')->unsigned();
            $table->string('alias');
            $table->text('content');
            $table->tinyInteger('rank')->default(0);
            
            $table->unique(['page_id', 'alias']);
            $table->foreign('page_id')->references('id')->on('structure_pages')->onDelete('CASCADE');        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('structure_pages_blocks');
    }
}
