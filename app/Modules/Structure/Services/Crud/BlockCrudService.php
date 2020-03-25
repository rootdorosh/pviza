<?php

namespace App\Modules\Structure\Services\Crud;

use App\Modules\Structure\Models\Page;
use App\Modules\Structure\Models\Block;
use App\Base\ScmsHelper;

/**
 * Class BlockCrudService
 */
class BlockCrudService
{
    /*
     * @param   Page $page
     * @param   array $data
     * @return  Page
     */
    public function insert(Page $page, array $data): Block
    {
        $widgetInstance = ScmsHelper::getWidgetInstance($data['widget_id']);
        foreach (array_flip($widgetInstance->attributes()) as $attr) {
            if (isset($data[$attr])) {
                $widgetInstance->$attr = $data[$attr];
            }
        }
        
        $widgetInstance->widget_id = $data['widget_id'];
        
        $block = Block::updateOrCreate(['page_id' => $page->id, 'alias' => $data['alias']], [
            'content' => serialize($widgetInstance),
            'rank' => (int) $data['alias'],
        ]);
        
        $block = Block::find($block->id);
        
        return $block;
    }

    /*
     * @param   Page $page
     * @param   string $alias
     * @return  void
     */
    public function destroy(Page $page, string $alias): void
    {
        $block = Block::where('page_id', $page->id)
            ->where('alias', $alias)
            ->first();
        
        if (!empty($block)) {
            $block->delete();
        }
    }
        
}
