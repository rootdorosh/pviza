<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::table('vacancy_categories_lang', function (Blueprint $table) {
            $table->longText('description')->change();
        });        
        Schema::table('vacancy_types_lang', function (Blueprint $table) {
            $table->longText('description')->change();
        });        
        Schema::table('vacancy_locations_lang', function (Blueprint $table) {
            $table->longText('description')->change();
        });        
        Schema::table('vacancy_lang', function (Blueprint $table) {
            $table->longText('description')->change();
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
    }
}
