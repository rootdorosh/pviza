<?php 

namespace App\Modules\Advantage\Services\Fetch;

use Illuminate\Support\Collection;
use App\Modules\Advantage\Models\Advantage;
use App\Base\FetchService;
use Cache;

/**
 * Class AdvantageFetchService
 */
class AdvantageFetchService extends FetchService
{    

    /**
     * @return  int
     */
    public static function getDefaultRank(): int
    {
        return (int) Advantage::max('rank') + 10;
    }   

    /*
     * @param int $categoryId
     * @param array $params
     * @return Collection
     */
    public function getItemsByCategoryId(int $categoryId, array $params = []): Collection
    {   
        $key = $this->tag . 'getItemsByCategoryId' . $categoryId . '_' . serialize($params);
        
        return Cache::tags($this->tag)->remember($key, self::EXP_MONTH, function() use ($categoryId, $params) {
            $query = $this->model::where('category_id', $categoryId);
            foreach ($params as $k => $v) {
                $query->where($k, $v);
            }
            $query->orderBy('rank', 'DESC');
            $items = $query->get();
            return $items !== null ? $items : collect([]);
        });        
    }
}


