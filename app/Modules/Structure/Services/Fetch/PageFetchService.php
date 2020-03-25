<?php

namespace App\Modules\Structure\Services\Fetch;

use Illuminate\Support\Collection;
use Cache;
use App\Base\FetchService;
use App\Modules\Structure\Models\Page;

/**
 * Class PageFetchService
 */
class PageFetchService extends FetchService
{
    /*
     * @return Collection
     */
    public function all(): Collection
    {   
        return Cache::tags($this->tag)->remember($this->tag . '_all', 60*60*24, function() {
            return $this->model::get();
        });        
    }
    
    /*
     * @param int $id
     * @return Page|null
     */
    public function byId(int $id): ?Page
    {   
        return Cache::tags($this->tag)->remember($this->tag . '_byId_' . $id, 60*60*24, function() use ($id) {
            return $this->model::find($id);
        });        
    }
}

