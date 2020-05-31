<?php

namespace App\Modules\Blog\Services\Fetch;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Base\FetchService;
use Cache;
use App\Modules\Blog\Models\Category;
use DB;

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
     * return Category
     */
    public function getByAlias(string $alias):? Category
    {
        $key = $this->tag . __FUNCTION__ . '_' . l() . $alias;

        return Cache::tags($this->tag)->remember($key, 1, function() use ($alias) {

            $query = $this->model::query()->select([
                DB::raw('blog_categories.id AS id'),
                DB::raw('blog_categories.image AS image'),
                DB::raw('blog_categories_lang.alias AS alias'),
                DB::raw('blog_categories_lang.title AS title'),
                DB::raw('blog_categories_lang.seo_h1 AS seo_h1'),
                DB::raw('blog_categories_lang.seo_title AS seo_title'),
                DB::raw('blog_categories_lang.seo_description AS seo_description'),
            ])
                ->leftJoin('blog_categories_lang', 'blog_categories.id', 'blog_categories_lang.category_id')
                ->where('blog_categories_lang.alias', $alias)
                ->where('blog_categories_lang.locale', l())
                ->where('blog_categories.is_active', 1);

            return $query->first();
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
            $items = DB::select("SELECT locale, alias FROM blog_categories_lang WHERE category_id = {$modelId}");
            $data = [];
            foreach ($items as $item) {
                $data[$item->locale] = d_l('/category/' . $item->alias, $item->locale);
            }
            return $data;
        });
    }


}


