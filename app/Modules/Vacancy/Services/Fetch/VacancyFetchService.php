<?php 

namespace App\Modules\Vacancy\Services\Fetch;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Base\FetchService;
use Cache;
use App\Modules\Vacancy\Models\Vacancy;
use App\Modules\Vacancy\Models\Location;
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
                $data[$item->id] = [
                    'id' => $item->id,
                    'title' => $item->title,
                    'alias' => $item->alias,
                ];
            }
            return $data;
        });        
    }
    
}


