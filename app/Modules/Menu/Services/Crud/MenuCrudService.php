<?php 

declare( strict_types = 1 );

namespace App\Modules\Menu\Services\Crud;

use App\Modules\Menu\Models\Menu;
use App\Services\Image\ImageService;
use App\Services\Storage\ImageStorageManager;

/**
 * Class MenuCrudService
 */
class MenuCrudService
{
    /**
     * @var ImageService
     */
    private $imageService;

    /**
     * @var array
     */
    private $attachedImages = [];

    /**
     * MenuCrudService constructor.
     *
     * @param ImageManagerInterface $imageService
     */
    public function __construct(ImageService $imageService) 
    {
        $this->imageService = $imageService;
    }

    /*
     * @param    array $data
     * @return  Menu
     */
    public function store(array $data): Menu
    {
        $menu = Menu::create($data);
        $this->syncItems($menu, $data['items']);
        
        return $menu;
    }

    /*
     * @param    Menu $menu
     * @param    Menu $data
     * @return  Menu
     */
    public function update(Menu $menu, array $data): Menu
    {
        $menu->update($data);
        $this->syncItems($menu, $data['items']);
        
        return $menu;
    }
    
    /*
     * @param    Menu $menu
     * @param    array $data
     * @return  void
     */
    public function syncItems(Menu $menu, array $tree): void
    {
        $tree = $this->itemsTreeExecute($menu, $tree);
        
        $menu->items = $tree;
        $menu->save();
        
        $this->cleanImages($menu);
    }
        
    /*
     * @param    Menu $menu
     * @param    array $tree
     * @return  array
     */
    public function itemsTreeExecute(Menu $menu, array $tree = []): array
    {
        if (is_array($tree) && count($tree)) {
            foreach ($tree as & $data) {
                    
                if (!empty($data['image']) && substr_count($data['image'], 'base64')) {
                    $data['image'] = $this->imageService->saveFromBase64($data['image'], [
                        'name' => $data['image_name'],
                        'path' => $this->getFolder($menu),
                        'withBasePath' => true,
                    ]);
                }
                
                if (isset($data['image_name'])) {
                    unset($data['image_name']);
                }
                
                if (!empty($data['image'])) {
                    $this->attachedImages[] = $data['image'];
                }
                
                $children = [];
                if (isset($data['children'])) {
                    $children = $data['children'];
                }
                $data['children'] = $this->itemsTreeExecute($menu, $children);
           }
        }
        
        return $tree;
    }
    
    /*
     * @param Menu $menu
     * @param bool $isAbsolute
     * @return string
     */
    public function getFolder(Menu $menu, $isAbsolute = false): string
    {
        $path = sprintf('menu/%s/', $menu->id);
        if ($isAbsolute) {
            $path = public_path() . ImageStorageManager::UPLOAD_PATH . '/' . $path;
        }
        
        return $path;
    }

    /*
     * @param    Menu $menu
     * @return  void
     */
    public function cleanImages(Menu $menu): void
    {
        $folder = $this->getFolder($menu, true);
        
        $files = glob($folder .  '*', GLOB_BRACE); 
        
        foreach ($files as $file) {
            if (!in_array(str_replace(public_path(), '', $file) ,$this->attachedImages)) {
                unlink($file);
            }
        }
    }
   
    /*
     * @param    Menu $menu
     * @return  void
     */
    public function destroy(Menu $menu): void
    {
        $menu->delete();
        
        $this->cleanImages($menu);
        
        $folder = $this->getFolder($menu, true);
        if (is_dir($folder)) {
            rmdir($folder);
        }
    }
   
    /*
     * @param   array $ids
     * @return  void
     */
    public function bulkDestroy(array $ids): void
    {
        foreach ($ids as $id) {
            $this->destroy(Menu::find($id));
        }
    }
}
