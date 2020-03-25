<?php
declare( strict_types = 1 );

namespace App\Services\Response;

use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Illuminate\Support\Str;

/**
 * Class FractalManager
 * @package App\Services\Fractal
 */
class FractalManager
{
    /**
     * @return array
     */
    public function collectionToFractalPaginate($request, $paginator, $transformer) : array
    {
        $paginator->appends($request->validated());
        $collection = $paginator->getCollection();
        
        $fractal = fractal()
           ->collection($collection, $transformer)
           ->paginateWith(new IlluminatePaginatorAdapter($paginator));
        
        $data = self::camelCaseKeys($fractal->toArray());
        
        if (!isset($data['meta']['pagination']['links']['next'])) {
            $data['meta']['pagination']['links']['next'] = null;
        }

        if (!isset($data['meta']['pagination']['links']['previous'])) {
            $data['meta']['pagination']['links']['previous'] = null;
        }
        
        $data['count'] = $data['meta']['pagination']['total'];
        
        return $data;
    }
    
    /**
     * @return array
     */
    public function collectionToFractal($collection, $transformer) : array
    {
        $fractal = fractal()
           ->collection($collection, $transformer);
        
        return $this->camelCaseKeys($fractal->toArray());
    }
    
    /**
     * @return array
     */
    public function formatResourceFractal($fractal) : array
    {
        return $this->camelCaseKeys($fractal->toArray());
    }
    
    /**
     * Convert array keys to camel case recursively.
     *
     * @param  array $array
     * @return string
     */
    public function camelCaseKeys($array)
    {
        $result = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = self::camelCaseKeys($value);
            }
            $result[Str::snake($key)] = $value;
        }
        return $result;
    }
}
