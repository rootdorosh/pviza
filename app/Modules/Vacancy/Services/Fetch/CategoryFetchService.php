<?php 

namespace App\Modules\Vacancy\Services\Fetch;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Base\FetchService;
use Cache;
use DB;
use App\Modules\Vacancy\Models\Category;

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
     * @param string $alias
     * @return Location
     */
    public function getByAlias(string $alias):? Category
    {   
        $key = $this->tag . __FUNCTION__ . '_' . l() . $alias;
        
        return Cache::tags($this->tag)->remember($key, 1, function() use ($alias) {
            $time = time();
            
            return $this->model::where('is_active', 1)
                ->leftJoin('vacancy_categories_lang', 'vacancy_categories.id', 'vacancy_categories_lang.category_id')
                ->where('alias', $alias)
                ->where('vacancy_categories_lang.locale', l())
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
           $items = DB::select("SELECT locale, alias FROM vacancy_categories_lang WHERE category_id = {$modelId}");
           $data = [];
           foreach ($items as $item) {
              $data[$item->locale] = d_l('/job-category/' . $item->alias, $item->locale);
           }
           return $data;
        });        
    }
    
}


