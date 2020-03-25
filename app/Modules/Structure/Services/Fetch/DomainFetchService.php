<?php

namespace App\Modules\Structure\Services\Fetch;

use App\Modules\Structure\Models\Domain;
use App\Base\FetchService;
use Cache;

/**
 * Class DomainFetchService
 */
class DomainFetchService extends FetchService
{    
    /**
     * @param string $alias
     * @return Domain|null
     */
    public function byAlias(string $alias): ?Domain
    {
        return Cache::tags($this->tag)->remember(
            $this->tag . '_byAlias_' . $alias, 60*60*24, function() use ($alias) {
            
            return $this->model::where('alias', $alias)
                        ->where('is_active', 1)
                        ->first();
        });        
    }   
}
