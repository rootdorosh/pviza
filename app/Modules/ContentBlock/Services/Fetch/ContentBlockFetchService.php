<?php 

namespace App\Modules\ContentBlock\Services\Fetch;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Modules\ContentBlock\Models\ContentBlock;
use App\Base\FetchService;
use Cache;

/**
 * Class ContentBlockFetchService
 */
class ContentBlockFetchService extends FetchService
{    
    /*
     * @return Collection
     */
    public function all(): Collection
    {   
        return Cache::tags($this->tag)->remember($this->tag . '_all', self::EXP_MONTH, function() {
            return $this->model::get();
        });        
    }
    
    /*
     * @return array
     */
    public function getList(): array
    {   
        return $this->all()->pluck('name', 'id')->toArray();        
    }
    
    /*
     * @param int $id
     * @param array $params
     * @return ContentBlock|bool|null
     */
    public function byId(int $id, array $params = [])
    {   
        $key = $this->tag . '_byId_' . $id . '_' . serialize($params);
        
        return Cache::tags($this->tag)->remember($key , self::EXP_MONTH, function() use ($id, $params) {
            $query = $this->model::where('id', $id);
            foreach ($params as $k => $v) {
                $query->where($k, $v);
            }
            $block = $query->first();
            return $block !== null ? $block : false;
        });        
    }
}


