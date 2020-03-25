<?php 

namespace App\Modules\Advantage\Services\Fetch;

use App\Modules\Advantage\Models\Category;
use App\Base\FetchService;
use Cache;

/**
 * Class CategoryFetchService
 */
class CategoryFetchService extends FetchService
{    
    /**
     * @return  array
     */
    public static function getList(): array
    {
        return Category::get()->pluck('title', 'id')->toArray();
    }   

    /**
     * @return  int
     */
    public static function getDefaultRank(): int
    {
        return (int) Category::max('rank') + 10;
    } 
    
    /*
     * @param int $id
     * @param array $params
     * @return ContentBlock|bool|null
     */
    public function byId(int $id, array $params = [])
    {   
        $key = $this->tag . '_byId_' . $id . '_' . serialize($params);
        
        return Cache::tags($this->tag)->remember($key, self::EXP_MONTH, function() use ($id, $params) {
            $query = $this->model::where('id', $id);
            foreach ($params as $k => $v) {
                $query->where($k, $v);
            }
            $block = $query->first();
            return $block !== null ? $block : false;
        });        
    }
    
}


