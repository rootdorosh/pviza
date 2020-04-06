<?php 

namespace App\Modules\Blog\Services\Fetch;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Base\FetchService;
use Cache;
use App\Modules\Blog\Models\Blog;

/**
 * Class BlogFetchService
 */
class BlogFetchService extends FetchService
{    

    /**
     * @return  int
     */
    public static function getDefaultRank(): int
    {
        return (int) Blog::max('rank') + 10;
    }   

}


