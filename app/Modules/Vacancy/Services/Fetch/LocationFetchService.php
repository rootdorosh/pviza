<?php 

namespace App\Modules\Vacancy\Services\Fetch;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Base\FetchService;
use Cache;
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

}


