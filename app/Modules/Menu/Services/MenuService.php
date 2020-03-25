<?php

namespace App\Modules\Menu\Services;

use App\Modules\Menu\Services\Fetch\MenuFetchService;
use App\Modules\Menu\Services\Fetch\ItemFetchService;
use App\Modules\Menu\Models\{
    Menu,
    Item
};
use FrontPage;
use Illuminate\Support\Facades\URL;

class MenuService
{
    /*
     * @param array $items
     * @param array $parentItem
     * @return array
     */
    public function setActive(array $items, array & $parentItem = null): array 
    {
        $activePage = FrontPage::getPage();
        $activePath = trim(request()->path(), '/');
        
        foreach ($items as & $item) {
            if (!empty($item['page_id']) && 
                !empty($activePage) &&
                $item['page_id'] === $activePage->id
            ) {
                $item['active'] = true;
            } elseif (trim($item['link'], '/') === $activePath) {
                $item['active'] = true;
            }
            
            if ($item['active'] && $parentItem) {
                $parentItem['active'] = true;
            }
            
            if (!empty($item['children'])) {
                $item['children'] = $this->setActive($item['children'], $item);
            }
        }
        
        return $items;
    }
}