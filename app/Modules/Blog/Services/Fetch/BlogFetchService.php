<?php

namespace App\Modules\Blog\Services\Fetch;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Base\FetchService;
use Cache;
use App\Modules\Blog\Models\{
    Blog,
    Category
};
use DB;

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

    /*
     * @param array $filter
     * @return Collection
     */
    public function getItems(array $filter): Collection
    {
        $key = $this->tag . '_getItems_' . l() . serialize($filter);
        $tags = [
            $this->tag,
            (new Category)->tag,
        ];

        return Cache::tags($this->tag)->remember($key, 1, function() use ($filter) {
            $page = !empty($filter['page']) ? (int) $filter['page'] : 1;
            $limit = !empty($filter['limit']) ? (int) $filter['limit'] : 10;
            $offset = $page * $limit - $limit;

            $wheres = [
                'blog.is_active = 1',
                'blog_categories.is_active = 1',
                'blog_lang.locale = "'.l().'"',
            ];

            if (!empty($filter['q'])) {
                $q = trim($filter['q']);
                $q = str_replace("'", "''", $q);

                $wheres[] = '(' . implode(' OR ', [
                    "blog_lang.title LIKE '%{$q}%'",
                    "blog_lang.description LIKE '%{$q}%'",
                ]) . ')';
            }

            if (!empty($filter['category_id'])) {
                $wheres[] = 'blog.category_id = ' . (int) $filter['category_id'];
            }

            $query = $this->model::query()->select([
                DB::raw('blog.id AS id'),
                DB::raw('blog.created_at AS created_at'),
                DB::raw('blog.image AS image'),
                DB::raw('blog_lang.alias AS alias'),
                DB::raw('blog_lang.title AS title'),
                DB::raw('blog_lang.description AS description'),
                DB::raw('blog_lang.alias AS alias'),
            ])
                ->leftJoin('blog_lang', 'blog.id', 'blog_lang.blog_id')
                ->leftJoin('blog_categories', 'blog.category_id', 'blog_categories.id');

            foreach ($wheres as $where) {
                $query->whereRaw($where);
            }
            $query->skip($offset)->limit($limit);
            $query->orderBy(DB::raw('blog.created_at'), 'DESC');

            return $query->get();
        });
    }

    /*
     * @param int $limit
     * @return Collection
     */
    public function getLatest(int $limit): Collection
    {
        $key = $this->tag . 'getLatest' . l() . $limit;
        $tags = [
            $this->tag,
            (new Category)->tag,
        ];

        return Cache::tags($this->tag)->remember($key, 1, function() use ($limit) {

            $wheres = [
                'blog.is_active = 1',
                'blog_categories.is_active = 1',
                'blog_lang.locale = "'.l().'"',
            ];

            $query = $this->model::query()->select([
                DB::raw('blog.id AS id'),
                DB::raw('blog.created_at AS created_at'),
                DB::raw('blog.image AS image'),
                DB::raw('blog_lang.alias AS alias'),
                DB::raw('blog_lang.title AS title'),
                DB::raw('blog_lang.description AS description'),
                DB::raw('blog_lang.alias AS alias'),
            ])
                ->leftJoin('blog_lang', 'blog.id', 'blog_lang.blog_id')
                ->leftJoin('blog_categories', 'blog.category_id', 'blog_categories.id');

            foreach ($wheres as $where) {
                $query->whereRaw($where);
            }
            $query->limit($limit);
            $query->orderBy(DB::raw('blog.created_at'), 'DESC');

            return $query->get();
        });
    }

    /*
     * @param int $categoryId
     * @param int $limit
     * @return Collection
     */
    public function getRelated(int $categoryId, int $limit): Collection
    {
        $key = $this->tag . 'getLatest' . l() . $categoryId . '_' . $limit;
        $tags = [
            $this->tag,
            (new Category)->tag,
        ];

        return Cache::tags($this->tag)->remember($key, 1, function() use ($categoryId, $limit) {
            $wheres = [
                'blog.category_id = ' . $categoryId,
                'blog.is_active = 1',
                'blog_categories.is_active = 1',
                'blog_lang.locale = "'.l().'"',
            ];

            $query = $this->model::query()->select([
                DB::raw('blog.id AS id'),
                DB::raw('blog.created_at AS created_at'),
                DB::raw('blog.image AS image'),
                DB::raw('blog_lang.alias AS alias'),
                DB::raw('blog_lang.title AS title'),
                DB::raw('blog_lang.description AS description'),
                DB::raw('blog_lang.alias AS alias'),
            ])
                ->leftJoin('blog_lang', 'blog.id', 'blog_lang.blog_id')
                ->leftJoin('blog_categories', 'blog.category_id', 'blog_categories.id');

            foreach ($wheres as $where) {
                $query->whereRaw($where);
            }
            $query->limit($limit);
            $query->orderBy(DB::raw('blog.created_at'), 'DESC');

            return $query->get();
        });
    }

    /*
     * @return Collection
     */
    public function getCategories(): Collection
    {
        $key = $this->tag . 'getCategories' . l();
        $tags = [
            $this->tag,
            (new Category)->tag,
        ];

        return Cache::tags($this->tag)->remember($key, 1, function() {

            $wheres = [
                'blog.is_active = 1',
                'blog_categories.is_active = 1',
                'blog_categories_lang.locale = "'.l().'"',
            ];

            $data = DB::select("
                    SELECT
                        blog_categories.id AS id,
                        blog_categories_lang.title AS title,
                        blog_categories_lang.alias AS alias,
                        COUNT(blog.id) AS c
                    FROM blog_categories
                    LEFT JOIN blog_categories_lang ON blog_categories.id = blog_categories_lang.category_id
                    LEFT JOIN blog ON blog_categories.id = blog.category_id
                    WHERE " . implode(' AND ', $wheres) . "
                    GROUP BY blog_categories.id
                    ORDER BY c DESC
                ");
            return collect($data);
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
            (new Category)->tag,
        ];

        return Cache::tags($this->tag)->remember($key, 1, function() use ($filter) {

            $wheres = ['blog.is_active = 1', 'c.is_active = 1'];

            if (!empty($filter['q'])) {
                $q = trim($filter['q']);
                $q = str_replace("'", "''", $q);

                $wheres[] = implode(' OR ', [
                    "blog_lang.title LIKE '%{$q}%'",
                    "blog_lang.description LIKE '%{$q}%'",
                ]);
            }

            if (!empty($filter['category_id'])) {
                $wheres[] = 'blog.category_id = ' . (int) $filter['category_id'];
            }

            $data = DB::select("
                    SELECT
                        COUNT(DISTINCT blog.id) AS c
                    FROM blog
                    LEFT JOIN blog_lang AS blog_lang ON blog.id = blog_lang.blog_id AND blog_lang.locale = '" . l() . "'
                    LEFT JOIN blog_categories AS c ON blog.category_id = c.id
                    WHERE " . implode(' AND ', $wheres) . "
                ");

            return $data[0]->c;
        });
    }

    /*
     * @param string $alias
     * return Blog
     */
    public function getByAlias(string $alias):? Blog
    {
        $key = $this->tag . __FUNCTION__ . '_' . l() . $alias;

        return Cache::tags($this->tag)->remember($key, 1, function() use ($alias) {

            $query = $this->model::query()->select([
                DB::raw('blog.id AS id'),
                DB::raw('blog.category_id AS category_id'),
                DB::raw('blog.created_at AS created_at'),
                DB::raw('blog.image AS image'),
                DB::raw('blog.image_header AS image_header'),
                DB::raw('blog_lang.alias AS alias'),
                DB::raw('blog_lang.title AS title'),
                DB::raw('blog_lang.description AS description'),
                DB::raw('blog_lang.alias AS alias'),
                DB::raw('blog_lang.seo_h1 AS seo_h1'),
                DB::raw('blog_lang.seo_title AS seo_title'),
                DB::raw('blog_lang.seo_description AS seo_description'),
            ])
                ->leftJoin('blog_lang', 'blog.id', 'blog_lang.blog_id')
                ->leftJoin('blog_categories', 'blog.category_id', 'blog_categories.id')
                ->where('blog_lang.alias', $alias)
                ->where('blog_lang.locale', l())
                ->where('blog.is_active', 1)
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
            $items = DB::select("SELECT locale, alias FROM blog_lang WHERE blog_id = {$modelId}");
            $data = [];
            foreach ($items as $item) {
                $data[$item->locale] = d_l('/' . $item->alias, $item->locale);
            }
            return $data;
        });
    }

}


