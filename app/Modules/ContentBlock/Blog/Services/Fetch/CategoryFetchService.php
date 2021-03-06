<?php 

namespace App\Modules\Blog\Services\Fetch;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Base\FetchService;
use Cache;
use App\Modules\Blog\Models\Category;

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

}


