<?php

namespace App\Modules\Structure\Services\Fetch;

use Illuminate\Support\Collection;
use Cache;
use App\Base\FetchService;
use App\Modules\Structure\Models\Block;

/**
 * Class BlockFetchService
 */
class BlockFetchService extends FetchService
{
    /*
     * @param int $pageId
     * @return Collection|null
     */
    public function itemsByPage(int $pageId): Collection
    {   
        $tag = (new Block(['page_id' => $pageId]))->getTag();
        $key = $tag . '_itemsByPage_' . $pageId;
        
        return Cache::tags($tag)->remember($key, self::EXP_MONTH, function() use ($pageId) {
            return $this->model::where('page_id', $pageId)->get();
        });        
    }
    
    /*
     * @param int $pageId
     * @param string $alias
     * @return array|null
     */
    public function itemByPageAndAlias(int $pageId, string $alias): ? array
    {   
        $tag = (new Block(['page_id' => $pageId]))->getTag();
        $key = $tag . "_itemByPageAndAlias_{$alias}";
        
        return Cache::tags($tag)->remember($key, self::EXP_MONTH, function() use ($pageId, $alias) {
            $data = $this->model::where('page_id', $pageId)->where('alias', $alias)->first();
            if (!empty($data)) {
                return (array)unserialize($data->content);
            } else {
                return null;
            }
        });       
    }
    
}

