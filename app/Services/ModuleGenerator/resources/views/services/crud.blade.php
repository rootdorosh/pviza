<?php 
use Illuminate\Support\Str;

$slugService = !empty($model['depedencies']['services']['crud']) && in_array('App\Services\SlugService', $model['depedencies']['services']['crud']);

?>
declare( strict_types = 1 );

namespace {{ $namespace }};

@foreach ($namespaceModels as $item)use {{ $item }};
@endforeach
@if (!empty($model['depedencies']['services']['crud']))
@foreach ($model['depedencies']['services']['crud'] as $depedency)
use {{ $depedency }};
@endforeach
@endif

/**
 * Class {{ $model['name'] }}CrudService
 */
class {{ $model['name'] }}CrudService
{
@if (!empty($model['depedencies']['services']['crud']))
@foreach ($model['depedencies']['services']['crud'] as $depedency)
    /**
     * @var {{ Str::afterLast($depedency, '\\') }}
     */
     
    private ${{ Str::camel(Str::afterLast($depedency, '\\')) }};
@endforeach

    /*
@foreach ($model['depedencies']['services']['crud'] as $depedency)
    * @param {{ Str::afterLast($depedency, '\\') }} ${{ Str::camel(Str::afterLast($depedency, '\\')) }}
@endforeach
    */
    public function __construct(@foreach ($model['depedencies']['services']['crud'] as $depedency)   
        {{ Str::afterLast($depedency, '\\') }} ${{ Str::camel(Str::afterLast($depedency, '\\')) }}{{ !$loop->last ? ',':'' }} @endforeach        
    )    
    {@foreach ($model['depedencies']['services']['crud'] as $depedency)    
        $this->{{ Str::camel(Str::afterLast($depedency, '\\')) }} = ${{ Str::camel(Str::afterLast($depedency, '\\')) }};@endforeach        
    }
@endif

    /*
     * @foreach ($signatureParams as $class => $var)     
     * @param   {{ $class }} {{ $var }}@endforeach     
     * @param  array $data
     * @return {{ $model['name'] }}
     */
    public function store(<?= implode(', ', array_merge($signatureParamsDelimeter, ['array $data']))?>): {{ $model['name'] }}
    {@if ($model['hasMedia']) 
        $data = $this->attatchMedia($data); @endif @if ($slugService) 
        $data = $this->slugService->handleLangs($data);
@endif
@if (!empty($model['parentModel']))
        $data['rank'] = (int) {{ $model['name'] }}::where('{{ Str::snake($model['parentModel']) }}_id', ${{ Str::camel($model['parentModel']) }}->id)->max('rank') + 1;
        
        return ${{ Str::camel($model['parentModel']) }}->{{ Str::camel($model['name_plural']) }}()->save(new {{ $model['name'] }}($data));
@else
        ${{ Str::camel($model['name']) }} = {{ $model['name'] }}::create($data);
        @if (!empty($model['hasBelongsToMany']))
$this->syncRelations(${{ Str::camel($model['name']) }}, $data);
        @endif
        
        return ${{ Str::camel($model['name']) }};
@endif
{{ "\t" }}}

    /*
     * @foreach ($signatureParams as $class => $var)     
     * @param   {{ $class }} {{ $var }}@endforeach     
     * @param  {{ $moduleName }} ${{ Str::camel($model['name']) }}
     * @param  {{ $model['name'] }} $data
     * @return {{ $model['name'] }}
     */
    public function update(<?= implode(', ', array_merge($signatureParamsDelimeter, [$model['name'] . ' $' . Str::camel($model['name']), 'array $data']))?>): {{ $model['name'] }}
    {@if ($model['hasMedia']) 
        $data = $this->attatchMedia($data, ${{ Str::camel($model['name']) }});
@endif @if ($slugService) 
        $data = $this->slugService->handleLangs($data);
@endif
        ${{ Str::camel($model['name']) }}->update($data);
        @if (!empty($model['hasBelongsToMany']))
$this->syncRelations(${{ Str::camel($model['name']) }}, $data);
        @endif
        
        return ${{ Str::camel($model['name']) }};
    }

    /*
     * @param  {{ $model['name'] }} ${{ Str::camel($model['name']) }}
     * @return void
     */
    public function destroy({{ $model['name'] }} ${{ Str::camel($model['name']) }}): void
    {
        ${{ Str::camel($model['name']) }}->delete();
    }
    
    /*
     * @param   array $ids
     * @return  void
     */
    public function bulkDestroy(array $ids): void
    {
        {{ $model['name'] }}::destroy($ids);
    }    
@if ($model['hasMedia'])      
    /*
     * @param  array $data
     * @param  {{ $model['name'] }} ${{ Str::camel($model['name']) }}
     * @return array
     */
    public function attatchMedia(array $data, {{ $model['name'] }} ${{ Str::camel($model['name']) }} = null): array
    {@foreach ($model['adaptiveImagesAttributes'] as $attr)      
        if (!empty($data['{{ $attr }}']) && is_array($data['{{ $attr }}'])) {
            $oldImages = ${{ Str::camel($model['name']) }}->{{ $attr }} ?? [];
            $data['{{ $attr }}'] = $this->imageService->saveAdaptiveImageBase64(
                $data['{{ $attr }}'], 
                $oldImages
            );
        }
@endforeach @foreach ($model['imagesAttributes'] as $attr)    
        $data = $this->imageService->attachImage(${{ Str::camel($model['name']) }}, '{{ $attr }}', $data);
@endforeach        
        return $data;
    }
@endif  
@if (!empty($model['parentModel']))
    /**
     * Sortable {{ Str::camel($model['name_plural']) }}
     *
     * @param array $ids
     * @return void
     */
    public function sortable(array $ids) : void
    {
        foreach ($ids as $rank => $id) {
            ${{ Str::camel($model['name']) }} = {{ $model['name'] }}::where('id', $id)->first();
            if (!empty(${{ Str::camel($model['name']) }})) {
                ${{ Str::camel($model['name']) }}->update(['rank' => $rank]);
            }
        }
    }
@endif

@if (!empty($model['hasBelongsToMany']))
    /**
     * Sync relations {{ Str::camel($model['name_plural']) }}
     *
     * @param {{ $model['name'] }} ${{ Str::camel($model['name_plural']) }}
     * @param array $data
     * @return void
     */
    public function syncRelations({{ $model['name'] }} ${{ Str::camel($model['name']) }}, array $data) : void
    {
@foreach ($model['fields'] as $attr => $field)@if (!empty($field['type']) && $field['type'] === 'array')
        ${{ Str::camel($model['name']) }}->{{ $field['relation']['name'] }}()->sync(!empty($data['{{ $field['relation']['name'] }}']) ? $data['{{ $field['relation']['name'] }}'] : []);@endif @endforeach
<?= "\n\t"?>}
@endif
    
}