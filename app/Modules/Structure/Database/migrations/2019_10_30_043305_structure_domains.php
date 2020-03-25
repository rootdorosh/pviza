<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StructureDomains extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('structure_domains', function (Blueprint $table) {
            $table->increments('id');
            $table->string('alias')->unique();
            $table->boolean('is_active')->default(0);
            $table->string('site_lang', 2)->nullable();
            $table->string('site_langs')->nullable();
            $table->string('logo')->nullable();
            $table->string('menus')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('structure_domains');
    }
}
