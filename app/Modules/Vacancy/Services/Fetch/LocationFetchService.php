<?php 

namespace App\Modules\Vacancy\Services\Fetch;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Base\FetchService;
use Cache;
use DB;
use App\Modules\Vacancy\Models\Location;

/**
 * Class LocationFetchService
 */
class LocationFetchService extends FetchService
{    
    /**
     * @return  array
     */
    public static function getList(): array
    {
        return Location::get()->pluck('title', 'id')->toArray();
    }   

    /**
     * @return  int
     */
    public static function getDefaultRank(): int
    {
        return (int) Location::max('rank') + 10;
    }   

    /*
     * @param string $alias
     * @return Location
     */
    public function getByAlias(string $alias):? Location
    {   
        $key = $this->tag . __FUNCTION__ . '_' . l() . $alias;
            
        return Cache::tags($this->tag)->remember($key, 1, function() use ($alias) {
            $time = time();
            
            return $this->model::where('is_active', 1)
                ->leftJoin('vacancy_locations_lang', 'vacancy_locations.id', 'vacancy_locations_lang.category_id')
                ->where('alias', $alias)
                ->where('vacancy_locations_lang.locale', l())
                ->first();
        });        
    }
    
    /*
     * @param (int $modelId
     * @return array
     */
    public function getLangMapLinks(int $modelId): array
    {   
        $key = $this->tag . __FUNCTION__ . '_' . $modelId;
        
        return Cache::tags($this->tag)->remember($key, 1, function() use ($modelId) {
           $items = DB::select("SELECT locale, alias FROM vacancy_locations_lang WHERE category_id = {$modelId}");
           $data = [];
           foreach ($items as $item) {
              $data[$item->locale] = d_l('/job-location/' . $item->alias, $item->locale);
           }
           return $data;
        });        
    }
    
}


