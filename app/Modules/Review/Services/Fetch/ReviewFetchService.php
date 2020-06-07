<?php

namespace App\Modules\Review\Services\Fetch;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Base\FetchService;
use Cache;
use App\Modules\Review\Models\Review;

/**
 * Class ReviewFetchService
 */
class ReviewFetchService extends FetchService
{

    /**
     * @return  int
     */
    public static function getDefaultRank(): int
    {
        return (int) Review::max('rank') + 10;
    }

    /*
     * @return Collection
     */
    public function getItems(array $filter): Collection
    {
        $key = $this->tag . '_getItems__' . serialize($filter);
        $tags = [
            $this->tag,
        ];

        return Cache::tags($this->tag)->remember($key, self::EXP_MONTH, function() use ($filter) {
            $page = !empty($filter['page']) ? (int) $filter['page'] : 1;
            $limit = !empty($filter['limit']) ? (int) $filter['limit'] : 9;
            $offset = $page * $limit - $limit;

            return $this->model::where('is_active', 1)
                ->skip($offset)
                ->limit($limit)
                ->orderBy('created_at', 'DESC')
                ->get();
        });
    }

    /*
     * @return Collection
     */
    public function getCountItems(): int
    {
        $key = $this->tag . 'getCountItems';
        $tags = [
            $this->tag,
        ];

        return Cache::tags($this->tag)->remember($key, self::EXP_MONTH, function() {
            return $this->model::where('is_active', 1)->count();
        });
    }


}


