<?php 

namespace App\Modules\Vacancy\Services\Fetch;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Base\FetchService;
use Cache;
use App\Modules\Vacancy\Models\Vacancy;

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

}


