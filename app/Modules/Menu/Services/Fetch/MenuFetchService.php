<?php

namespace App\Modules\Menu\Services\Fetch;

use Illuminate\Support\Collection;
use Cache;
use App\Base\FetchService;
use App\Modules\Menu\Models\Menu;
use App\Modules\Structure\Services\StructureService;
use App\Modules\Structure\Models\Domain;
use App\Modules\Structure\Models\Page;

/**
 * Class MenuFetchService
 */
class MenuFetchService extends FetchService
{
    /**
     * @var StructureService
     */
    private $structureService;

    /**
     * MenuFetchService constructor.
     *
     * @param StructureService $structureService
     */
    public function __construct(StructureService $structureService) 
    {
        $this->structureService = $structureService;
        
        return parent::__construct();
    }

    /*
     * @return Collection
     */
    public function all(): Collection
    {   
        return Cache::tags($this->tag)->remember($this->tag . '_all_', self::EXP_MONTH, function() {
            return $this->model::get();
        });        
    }
    
    /*
     * @return array
     */
    public function getList(): array
    {   
        return $this->all()->pluck('title', 'id')->toArray();        
    }
    
    /*
     * @param int $id
     * @param array $params
     * @return Menu|bool|null
     */
    public function byId(int $id, array $params = [])
    {   
        $key = $this->tag . '_byId_' . $id . '_' . serialize($params);
        
        return Cache::tags($this->tag)->remember($key , self::EXP_MONTH, function() use ($id, $params) {
            $query = $this->model::where('id', $id);
            foreach ($params as $k => $v) {
                $query->where($k, $v);
            }
            $menu = $query->first();
            return $menu !== null ? $menu : false;
        });        
    }
    
    /*
     * @param Domain $domain
     * @param int $id
     * @param array $params
     * @return array|null
     */
    public function getItems(Domain $domain, int $id, array $params = []):? array
    {   
        $key = $this->tag . '_getItems__' . $id . '_' . serialize($params) . '_' . l();
        $tags = [
            (new Page)->getTag(),
            $this->tag,
        ];
        
        return Cache::tags($tags)->remember($key , self::EXP_MONTH, function() use ($domain, $id, $params) {
            $query = $this->model::where('id', $id);
            foreach ($params as $k => $v) {
                $query->where($k, $v);
            }
            $menu = $query->first();
                        
            return $menu !== null ? $this->resolveTreeParams($domain, $menu->items) : null;
        });        
    }
    
    /*
     * @param Domain $domain
     * @param    array $tree
     * @return  array
     */
    public function resolveTreeParams(Domain $domain, array $tree): array
    {
        if (is_array($tree) && count($tree)) {
            foreach ($tree as & $data) {
                
                $children = [];
                if (isset($data['children'])) {
                    $children = $data['children'];
                }
                
                $data['title'] = !empty($data[l()]['title']) ? $data[l()]['title'] : $data['name'];
                $data['link'] = !empty($data[l()]['link']) ? $data[l()]['link'] : 
                    $this->structureService->getPageUrlById($domain, $data['page_id']);
                
                $data['active'] = $data['link'] === request()->url;
                
                
                $data['children'] = $this->resolveTreeParams($domain, $children);
           }
        }
        
        return $tree;
    }
}

