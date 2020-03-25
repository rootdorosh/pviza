<?php 

namespace App\Modules\Vacancy\Services\Fetch;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Base\FetchService;
use Cache;
use App\Modules\Vacancy\Models\Type;

/**
 * Class TypeFetchService
 */
class TypeFetchService extends FetchService
{    
    /**
     * @return  array
     */
    public static function getList(): array
    {
        return Type::get()->pluck('title', 'id')->toArray();
    }   

    /**
     * @return  int
     */
    public static function getDefaultRank(): int
    {
        return (int) Type::max('rank') + 10;
    }   

}


