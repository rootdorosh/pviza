<?php 
use Illuminate\Support\Str;
use App\Services\ModuleGenerator\ModuleGeneratorService;
$tab5 = "                    ";
$tab4 = "                ";
$tab3 = "            ";
$tab2 = "        ";

$tab1 = "    ";
?>
declare( strict_types = 1 );

namespace {{ $namespace }};

use Illuminate\Database\Eloquent\Model;
@if(!empty($relationsTypes))@foreach ($relationsTypes as $relationsType)
use Illuminate\Database\Eloquent\Relations\{{ $relationsType }};    
@endforeach
@endif
@foreach ($model['depedencies']['model'] as $dep)
use {{ $dep }};
@endforeach

class {{ $model['name'] }} extends Model
{
    use <?= implode(', ', $model['depedenciesShort']['model'])?>;
    
    /**
     * @var bool
     */
    public $timestamps = false;
{!! ModuleGeneratorService::model_const($model) !!}
    /*
     * @var string
     */
    public $table = '{{ $model['table'] }}';
@if (!empty($model['translatable']))
    
    /**
     * @var string
     */
	public $translationForeignKey = '{{ $model['translatable']['owner_id'] }}';	

    /*
     * @var array
     */
    public $translatedAttributes = [@foreach ($model['translatable']['fields'] as $attr => $item){!! "\n{$tab2}" !!}'{!! $attr !!}',@endforeach {!! "\n{$tab1}" !!}];

    /*
     * @var array
     */
    protected $with = ['translations'];
    @endif
    
    /**
     * The attributes that are mass assignable.
     
     * @var array
     */
    public $fillable = [@foreach ($model['fields'] as $attr => $item) @if($item['fillable']){!! "\n{$tab2}" !!}'{!! $attr !!}', @endif @endforeach {!! "\n{$tab1}" !!}];  
@foreach ($relations as $item)  
    /**
     * Get the {{ $item['name'] }}.
     *
     * @return {{ $item['type'] }}
     */
    public function {{ $item['name'] }}() : {{ $item['type'] }}
    {@if ($item['type'] === 'BelongsToMany')    
        return $this->{{ Str::camel($item['type']) }}('{{ $item['model'] }}', '{{ $item['table'] }}');@else 
        return $this->{{ Str::camel($item['type']) }}('{{ $item['model'] }}');
    @endif
<?= "\n\t"?>}
@endforeach
<?= $mutators?>

}