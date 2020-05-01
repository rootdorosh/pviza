<?php 
use Illuminate\Support\Str;
?>
declare( strict_types = 1 );

namespace {{ $namespace }};

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Base\ExtArrHelper;
@foreach ($namespaceModels as $item)use {{ $item }};
@endforeach
use {{ $requestNamespace }}\{
    {{ implode(",\n\t", $requests) }}
};
<?= implode(";\n", $dependenciesUse)?>;


/**
 * @group {{ strtoupper(Str::snake($moduleName)) }}
 */
class {{ $model['name'] }}Controller extends Controller
{
@if (!empty($dependenciesVars))
@foreach ($dependenciesVars as $var => $name)
    
    /**
     * @var {{ $name }}
     */
    private ${{ $var }};
@endforeach

    /*
@foreach ($dependenciesVars as $var => $name)
    * @param {{ $name }} ${{ $var }}
@endforeach
    */
    public function __construct(@foreach ($dependenciesVars as $var => $name)   
        {{ $name }} ${{ $var }}{{ !$loop->last ? ',':'' }} @endforeach        
    ) 
    {@foreach ($dependenciesVars as $var => $name)    
        $this->{{ $var }} = ${{ $var }};@endforeach        
    }
@endif
    
    /**
     * {{ $functionSignatureTitle }} meta
     *
     * @authenticated
     * 
     * @responseFile 200 responses/{{ $responsePath }}/meta/200.json
     * @foreach ($signatureParams as $class => $var)     
     * @param   {{ $class }} {{ $var }}@endforeach     
     * @param MetaRequest $request
     * @return  JsonResponse
     */
    public function meta(<?= implode(', ', array_merge($signatureParamsDelimeter, ['MetaRequest $request']))?>): JsonResponse
    {
        <?= $meta?>
    }

    /**
     * {{ $functionSignatureTitle }} list
     *
     * @authenticated
     * 
     * @responseFile 200 responses/{{ $responsePath }}/index/200.json
     * @responseFile 422 responses/{{ $responsePath }}/index/422.json
     * @foreach ($signatureParams as $class => $var)     
     * @param   {{ $class }} {{ $var }}@endforeach     
     * @param   IndexRequest $request
     * @return  JsonResponse
     */
    public function index(<?= implode(', ', array_merge($signatureParamsDelimeter, ['IndexRequest $request']))?>): JsonResponse
    {
@if (empty($model['parentModel']))    
        return response()->json($this->fractalManager->collectionToFractalPaginate(
            $request,
            $request->paginate(),
            $this->transformer
        ));
@else
        return response()->json($this->fractalManager->collectionToFractal(
            $this->fetchService->getData(${{ Str::camel($model['parentModel']) }}),
            $this->transformer
        ));
@endif
    }
@if (!( !empty($model['exceptCrud']) && in_array('store', $model['exceptCrud'])) )
    /**
     * {{ $functionSignatureTitle }} store
     *
     * @authenticated
     * 
     * @responseFile 201 responses/{{ $responsePath }}/store/201.json
     * @responseFile 422 responses/{{ $responsePath }}/store/422.json
     * @foreach ($signatureParams as $class => $var)     
     * @param   {{ $class }} {{ $var }}@endforeach     
     * @param   FormRequest $request
     * @return  JsonResponse
     */
    public function store(<?= implode(', ', array_merge($signatureParamsDelimeter, ['FormRequest $request']))?>): JsonResponse
    {
        ${{ Str::camel($model['name']) }} = $this->crudService->store(<?= implode(', ', array_merge($signatureParams, ['$request->validated()']))?>);
        
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item(${{ Str::camel($model['name']) }}, $this->transformer->setItemIncludes())
        );
@if (!empty($model['translatable']))        
        return response()->json(ExtArrHelper::transformModelLang($data), 201);@else
        return response()->json($data, 201);@endif            
    }
@endif
@if (!( !empty($model['exceptCrud']) && in_array('update', $model['exceptCrud'])) )
    /**
     * {{ $functionSignatureTitle }} update
     *
     * @authenticated
     * 
     * @responseFile 200 responses/{{ $responsePath }}/update/200.json
     * @responseFile 422 responses/{{ $responsePath }}/update/422.json
     * @responseFile 404 responses/{{ $responsePath }}/update/404.json
     * @foreach ($signatureParams as $class => $var)     
     * @param   {{ $class }} {{ $var }}@endforeach     
     * @param   {{ $model['name'] }} ${{ Str::camel($model['name']) }}
     * @param   FormRequest $request
     * @return  JsonResponse
     */
    public function update(<?= implode(', ', array_merge($signatureParamsDelimeter, [$model['name'] . ' $' . Str::camel($model['name']), 'FormRequest $request']))?>): JsonResponse
    {
        ${{ Str::camel($model['name']) }} = $this->crudService->update(<?= implode(', ', array_merge($signatureParams, ['$'.Str::camel($model['name']), '$request->validated()']))?>);
        
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item(${{ Str::camel($model['name']) }}, $this->transformer->setItemIncludes())
        );
@if (!empty($model['translatable']))        
        return response()->json(ExtArrHelper::transformModelLang($data), 201);@else
        return response()->json($data, 201);@endif            
    }
@endif
@if (!( !empty($model['exceptCrud']) && in_array('update', $model['exceptCrud']) && empty($model['uiView'])))
    /**
     * {{ $functionSignatureTitle }} show
     *
     * @authenticated
     * 
     * @responseFile 200 responses/{{ $responsePath }}/show/200.json
     * @responseFile 422 responses/{{ $responsePath }}/show/404.json
     * @foreach ($signatureParams as $class => $var)     
     * @param   {{ $class }} {{ $var }}@endforeach     
     * @param   {{ $model['name'] }} ${{ Str::camel($model['name']) }}
     * @param   ShowRequest $request
     * @return  JsonResponse
     */
    public function show(<?= implode(', ', array_merge($signatureParamsDelimeter, [$model['name'] . ' $' . Str::camel($model['name']), 'ShowRequest $request']))?>): JsonResponse
    {
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item(${{ Str::camel($model['name']) }}, $this->transformer->setItemIncludes())
        );
@if (!empty($model['translatable']))        
        return response()->json(ExtArrHelper::transformModelLang($data), 200);@else
        return response()->json($data, 200);@endif            
    }
@endif
    /**
     * {{ $functionSignatureTitle }} destroy
     *
     * @authenticated
     * 
     * @responseFile 204 responses/{{ $responsePath }}/destroy/204.json
     * @responseFile 422 responses/{{ $responsePath }}/destroy/404.json
     * @foreach ($signatureParams as $class => $var)     
     * @param   {{ $class }} {{ $var }}@endforeach     
     * @param   {{ $model['name'] }} ${{ Str::camel($model['name']) }}
     * @param   DestroyRequest $request
     * @return  JsonResponse
     */
    public function destroy(<?= implode(', ', array_merge($signatureParamsDelimeter, [$model['name'] . ' $' . Str::camel($model['name']), 'DestroyRequest $request']))?>): JsonResponse
    {
        $this->crudService->destroy(${{ Str::camel($model['name']) }});
        return response()->json(null, 204);
    }
    
    /**
     * {{ $functionSignatureTitle }} bulk destroy
     *
     * @authenticated
     * 
     * @responseFile 204 responses/{{ $responsePath }}/bulk_destroy/204.json
     * @responseFile 422 responses/{{ $responsePath }}/bulk_destroy/422.json
     * @foreach ($signatureParams as $class => $var)     
     * @param   {{ $class }} {{ $var }}@endforeach     
     * @param   BulkDestroyRequest $request
     * @return  JsonResponse
     */
    public function bulkDestroy(<?= implode(', ', array_merge($signatureParamsDelimeter, ['BulkDestroyRequest $request']))?>): JsonResponse
    {
        $this->crudService->bulkDestroy($request->ids);
        return response()->json(null, 204);
    }    
<?php if (!empty($model['parentModel'])):?>    
    /**
     * {{ $functionSignatureTitle }} sortable
     *
     * @authenticated
     * 
     * @responseFile 204 responses/{{ $responsePath }}/sortable/204.json
     * @responseFile 422 responses/{{ $responsePath }}/sortable/422.json
     * @foreach ($signatureParams as $class => $var)     
     * @param   {{ $class }} {{ $var }}@endforeach     
     * @param   BulkDestroyRequest $request
     * @return  JsonResponse
     */
    public function sortable(<?= implode(', ', array_merge($signatureParamsDelimeter, ['SortableRequest $request']))?>): JsonResponse
    {
        $this->crudService->sortable($request->ids);
        return response()->json(null, 204);
    }
<?php endif;?>    
}