namespace {{ $namespace }};

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Base\FetchService;
use Cache;
@foreach ($namespaceModels as $item)use {{ $item }};
@endforeach

/**
 * Class {{ $model['name'] }}FetchService
 */
class {{ $model['name'] }}FetchService extends FetchService
{    
@if (!empty($model['classConfig']['fetchService']['functions']['getList']))
    /**
     * @return array
     */
    public static function getList(): array
    {
        return {{ $model['name'] }}::get()->pluck('{{ $model['classConfig']['fetchService']['functions']['getList'] }}', 'id')->toArray();
    }   
@endif

@if (!empty($model['classConfig']['fetchService']['functions']['getDefaultRank']) && empty($model['parentModel']))
    /**
     * @return int
     */
    public static function getDefaultRank(): int
    {
        return (int) {{ $model['name'] }}::max('rank') + <?= $model['classConfig']['fetchService']['functions']['getDefaultRank']?>;
    }   
@endif

@if (!empty($model['parentModel']))
    /**
     * @param {{ $model['parentModel'] }} ${{ Str::camel($model['parentModel']) }}
     * @return Collection
     */
    public static function getData({{ $model['parentModel'] }} ${{ Str::camel($model['parentModel']) }}): Collection
    {
        return ${{ Str::camel($model['parentModel']) }}->{{ Str::camel($model['name_plural']) }}()->orderBy('{{ $orderAttr }}', '{{ $orderDir }}')->get();
    } 
    
    /**
     * @param {{ $model['parentModel'] }} ${{ Str::camel($model['parentModel']) }}
     * @return int
     */
    public static function getDefaultRank({{ $model['parentModel'] }} ${{ Str::camel($model['parentModel']) }}): int
    {
        return (int) {{ $model['name'] }}::where('{{ Str::snake($model['parentModel']) }}_id', ${{ Str::camel($model['parentModel']) }}->id)->max('rank') + <?= $model['classConfig']['fetchService']['functions']['getDefaultRank'] ?? 1?>;
    }   
    
@endif
}


