<?php 
use Illuminate\Support\Str;
use App\Services\ModuleGenerator\ModuleGeneratorService;
?>
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create{{ $className }} extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('{{ $model['table'] }}_lang', function (Blueprint $table) {
{!! $up !!}        
          
            $table->unique(['{{ $model['translatable']['owner_id'] }}', 'locale']);
            $table->foreign('{{ $model['translatable']['owner_id'] }}')->references('id')->on('{{ $model['table'] }}')->onDelete('cascade');        
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('{{ $model['table'] }}_lang');
    }
}
