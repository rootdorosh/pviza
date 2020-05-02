<?php
namespace App\Modules\Vacancy\Services\Fetch;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Base\FetchService;
use Cache;
use App\Modules\Vacancy\Models\{
    Vacancy,
    Location,
    Type,
    Category
};
use DB;

/**
 * Class VacancyFetchService
 */
class VacancyFetchService extends FetchService
{
    /**
     * @return  int
     */
    public static function getDefaultRank(): int
    {
        return (int) Vacancy::max('rank') + 10;
    }

    /*
     * @return array
     */
    public function getLocations(): array
    {
        $key = $this->tag . 'getLocations_' . l();
        $tags = [$this->tag, (new Location)->tag];

        return Cache::tags($this->tag)->remember($key, self::EXP_MONTH, function() {

                $items = Location::select([
                        DB::raw('vacancy_locations.id AS id'),
                        DB::raw('vacancy_locations_lang.title AS title'),
                        DB::raw('vacancy_locations_lang.alias AS alias'),
                    ])
                    ->leftJoin('vacancy_locations_lang', 'vacancy_locations.id', 'vacancy_locations_lang.category_id')
                    ->leftJoin('vacancy_vs_location', 'vacancy_locations.id', 'vacancy_vs_location.location_id')
                    ->leftJoin('vacancy', 'vacancy_vs_location.vacancy_id', 'vacancy.id')
                    ->where('vacancy_locations_lang.locale', l())
                    ->where('vacancy_locations.is_active', 1)
                    ->where('vacancy.is_active', 1)
                    ->orderBy('vacancy_locations.rank', 'DESC')
                    ->get();

                $data = [];

                foreach ($items as $item) {
                    $data[$item->id] = $item->toArray();
                }
                return $data;
            });
    }

    /*
     * @param array $filter
     * @return array
     */
    public function getItems(array $filter): array
    {
        $key = $this->tag . '_getItems_' . l() . serialize($filter);
        $tags = [
            $this->tag,
            (new Location)->tag,
            (new Category)->tag,
            (new Type)->tag,
        ];

        return Cache::tags($this->tag)->remember($key, 1, function() use ($filter) {
                $page = !empty($filter['page']) ? (int) $filter['page'] : 1;
                $limit = !empty($filter['limit']) ? (int) $filter['limit'] : 10;
                $offset = $page * $limit - $limit;
            
                $wheres = ['v.is_active = 1'];
                if (!empty($filter['q'])) {
                    $q = trim($filter['q']);
                    $q = str_replace("'", "''", $q);
                    
                    $wheres[] = implode(' OR ', [
                        "vac_lang.title LIKE '%{$q}%'",
                        "vac_lang.work_schedule LIKE '%{$q}%'",
                        "vac_lang.salary LIKE '%{$q}%'",
                        "vac_lang.description LIKE '%{$q}%'",
                    ]);
                }
                
                if (!empty($filter['location_id'])) {
                    $wheres[] = 'vs_loc.location_id = ' . (int) $filter['location_id'];
                }
                
                if (!empty($filter['type_id'])) {
                    $wheres[] = 'vs_type.type_id = ' . (int) $filter['type_id'];
                }
                
                if (!empty($filter['category_id'])) {
                    $wheres[] = 'vs_cat.category_id = ' . (int) $filter['category_id'];
                }
                $sql = "
                    SELECT 
                        v.id AS id,
                        v.date_posted AS date_posted,
                        v.hiring_organization AS hiring_organization,
                        vac_lang.alias AS alias,
                        vac_lang.title AS title,
                        vac_lang.work_schedule AS work_schedule,
                        vac_lang.contract_type AS contract_type,
                        vac_lang.salary AS salary,
                        GROUP_CONCAT(DISTINCT loc_lang.title ORDER BY loc_lang.title SEPARATOR ', ') AS locations,
                        GROUP_CONCAT(DISTINCT type_lang.title ORDER BY type_lang.title SEPARATOR ', ') AS types,
                        GROUP_CONCAT(DISTINCT cat_lang.title ORDER BY cat_lang.title SEPARATOR ', ') AS categories
                    FROM vacancy AS v
                    LEFT JOIN vacancy_lang AS vac_lang ON v.id = vac_lang.vacancy_id AND vac_lang.locale = '" . l() . "'
                    LEFT JOIN vacancy_vs_location AS vs_loc ON v.id = vs_loc.vacancy_id
                    LEFT JOIN vacancy_locations_lang AS loc_lang ON vs_loc.location_id = loc_lang.category_id AND loc_lang.locale = '" . l() . "'
                    LEFT JOIN vacancy_vs_type AS vs_type ON v.id = vs_type.vacancy_id
                    LEFT JOIN vacancy_types_lang AS type_lang ON vs_type.type_id = type_lang.category_id AND type_lang.locale = '" . l() . "'
                    LEFT JOIN vacancy_vs_category AS vs_cat ON v.id = vs_cat.vacancy_id
                    LEFT JOIN vacancy_categories_lang AS cat_lang ON vs_cat.category_id = cat_lang.category_id AND cat_lang.locale = '" . l() . "'
                    WHERE " . implode(' AND ', $wheres) . "
                    GROUP BY v.id
                    ORDER BY v.rank DESC, v.date_posted DESC
                    LIMIT $offset, $limit
                ";
                return DB::select($sql);
            });
    }

    /*
     * @param array $filter
     * @return int
     */
    public function getCountItems(array $filter): int
    {
        $key = $this->tag . 'getCountItems' . l() . serialize($filter);
        $tags = [
            $this->tag,
            (new Location)->tag,
            (new Category)->tag,
            (new Type)->tag,
        ];

        return Cache::tags($this->tag)->remember($key, 1, function() use ($filter) {
                
                $wheres = ['v.is_active = 1'];
                
                if (!empty($filter['q'])) {
                    $q = trim($filter['q']);
                    $q = str_replace("'", "''", $q);
                    
                    $wheres[] = implode(' OR ', [
                        "vac_lang.title LIKE '%{$q}%'",
                        "vac_lang.work_schedule LIKE '%{$q}%'",
                        "vac_lang.salary LIKE '%{$q}%'",
                        "vac_lang.description LIKE '%{$q}%'",
                    ]);
                }
                
                if (!empty($filter['location_id'])) {
                    $wheres[] = 'vs_loc.location_id = ' . (int) $filter['location_id'];
                }
                
                if (!empty($filter['type_id'])) {
                    $wheres[] = 'vs_type.type_id = ' . (int) $filter['type_id'];
                }
                
                if (!empty($filter['category_id'])) {
                    $wheres[] = 'vs_category.category_id = ' . (int) $filter['category_id'];
                }
                
                $data = DB::select("
                    SELECT 
                        COUNT(DISTINCT v.id) AS c
                    FROM vacancy AS v
                    LEFT JOIN vacancy_lang AS vac_lang ON v.id = vac_lang.vacancy_id AND vac_lang.locale = '" . l() . "'
                    LEFT JOIN vacancy_vs_location AS vs_loc ON v.id = vs_loc.vacancy_id
                    LEFT JOIN vacancy_vs_type AS vs_type ON v.id = vs_type.vacancy_id
                    LEFT JOIN vacancy_vs_category AS vs_cat ON v.id = vs_cat.vacancy_id
                    WHERE " . implode(' AND ', $wheres) . "
                ");
                
                return $data[0]->c;
            });
    }

    /*
     * @return array
     */
    public function getFilterLocations(): array
    {
        $key = $this->tag . 'getFilterLocations' . l();
        $tags = [$this->tag, (new Location)->tag];

        return Cache::tags($this->tag)->remember($key, self::EXP_MONTH, function() {

                $items = Location::select([
                        DB::raw('vacancy_locations.id AS id'),
                        DB::raw('vacancy_locations_lang.title AS title'),
                        DB::raw('vacancy_locations_lang.alias AS alias'),
                        DB::raw('(
                        SELECT COUNT(DISTINCT v.id) FROM vacancy AS v
                        LEFT JOIN vacancy_vs_location AS vs ON v.id = vs.vacancy_id
                        WHERE v.is_active = 1 AND vs.location_id = vacancy_locations.id
                    ) c'),
                    ])
                    ->leftJoin('vacancy_locations_lang', 'vacancy_locations.id', 'vacancy_locations_lang.category_id')
                    ->where('vacancy_locations_lang.locale', l())
                    ->where('vacancy_locations.is_active', 1)
                    ->havingRaw('c > 0')
                    ->orderBy('c', 'DESC')
                    ->get();

                $data = [];

                foreach ($items as $item) {
                    $data[] = $item->toArray();
                }
                return $data;
            });
    }

    /*
     * @return array
     */
    public function getFilterCategories(): array
    {
        $key = $this->tag . 'getFilterCategories' . l();
        $tags = [$this->tag, (new Category)->tag];

        return Cache::tags($this->tag)->remember($key, self::EXP_MONTH, function() {

                $items = Category::select([
                        DB::raw('vacancy_categories.id AS id'),
                        DB::raw('vacancy_categories_lang.title AS title'),
                        DB::raw('vacancy_categories_lang.alias AS alias'),
                        DB::raw('(
                        SELECT COUNT(DISTINCT v.id) FROM vacancy AS v
                        LEFT JOIN vacancy_vs_category AS vs ON v.id = vs.vacancy_id
                        WHERE v.is_active = 1 AND vs.category_id = vacancy_categories.id
                    ) c'),
                    ])
                    ->leftJoin('vacancy_categories_lang', 'vacancy_categories.id', 'vacancy_categories_lang.category_id')
                    ->where('vacancy_categories_lang.locale', l())
                    ->where('vacancy_categories.is_active', 1)
                    ->havingRaw('c > 0')
                    ->orderBy('c', 'DESC')
                    ->get();

                $data = [];

                foreach ($items as $item) {
                    $data[] = $item->toArray();
                }
                return $data;
            });
    }

    /*
     * @return array
     */
    public function getFilterTypes(): array
    {
        $key = $this->tag . 'getFilterTypes' . l();
        $tags = [$this->tag, (new Type)->tag];

        return Cache::tags($this->tag)->remember($key, self::EXP_MONTH, function() {

                $items = Type::select([
                        DB::raw('vacancy_types.id AS id'),
                        DB::raw('vacancy_types_lang.title AS title'),
                        DB::raw('vacancy_types_lang.alias AS alias'),
                        DB::raw('(
                        SELECT COUNT(DISTINCT v.id) FROM vacancy AS v
                        LEFT JOIN vacancy_vs_type AS vs ON v.id = vs.vacancy_id
                        WHERE v.is_active = 1 AND vs.type_id = vacancy_types.id
                    ) c'),
                    ])
                    ->leftJoin('vacancy_types_lang', 'vacancy_types.id', 'vacancy_types_lang.category_id')
                    ->where('vacancy_types_lang.locale', l())
                    ->where('vacancy_types.is_active', 1)
                    ->havingRaw('c > 0')
                    ->orderBy('c', 'DESC')
                    ->get();

                $data = [];

                foreach ($items as $item) {
                    $data[] = $item->toArray();
                }
                return $data;
            });
    }

    /*
     * @param string $alias
     * @return Vacancy
     */
    public function getByAlias(string $alias):? Vacancy
    {   
        $key = $this->tag . __FUNCTION__ . '_' . l() . $alias;
        
        return Cache::tags($this->tag)->remember($key, 1, function() use ($alias) {
            $time = time();
            
            return $this->model::where('is_active', 1)
                ->leftJoin('vacancy_lang', 'vacancy.id', 'vacancy_lang.vacancy_id')
                ->where('alias', $alias)
                ->where('vacancy_lang.locale', l())
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
           $items = DB::select("SELECT locale, alias FROM vacancy_lang WHERE vacancy_id = {$modelId}");
           $data = [];
           foreach ($items as $item) {
              $data[$item->locale] = d_l('/jobs/' . $item->alias, $item->locale);
           }
           return $data;
        });        
    }
    
    
}
