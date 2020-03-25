<?php

namespace App\Modules\Structure\Services\Crud;

use App\Modules\Structure\Models\Domain;
use App\Modules\Structure\Models\Page;
use App\Services\Image\ImageService;
use App\Modules\Structure\Services\StructureService;


/**
 * Class PageCrudService
 */
class PageCrudService
{
    /**
     * @var StructureService
     */
    private $structureService;

    /**
     * @var ImageService
     */
    private $imageService;

    /**
     * DomainCrudService constructor.
     *
     * @param ImageManagerInterface $imageService
     * @param StructureService $structureService
     */
    public function __construct(ImageService $imageService, StructureService $structureService) 
    {
        $this->imageService = $imageService;
        $this->structureService = $structureService;
    }

    /*
     * @param   array $data
     * @return  Page
     */
    public function store(array $data): Page
    {
        $parentPage = Page::find($data['parent_id']);

        return  $this->structureService->makePage(
            $parentPage, 
            $data
        );
    }

    /*
     * @param   Page $data
     * @return  Page
     */
    public function update(Page $page, array $data): Page
    {
        //$data = $this->saveMedia($data);
        
        $page->update($data);
        
        return $page;
    }

    /*
     * @param   Page $page
     * @return  void
     */
    public function destroy(Page $page): void
    {
        $this->structureService->removePage($page);        
    }
    
    /*
     * @param   Page $page
     * @param   array $data
     * @return  Page
     */
    public function move(Page $page, array $data): Page
    {
        return $this->structureService->movePage($page, $data['parent_id']);
    }
    
    /*
     * @param   Page $page
     * @return  Page
     */
    public function copy(Page $page): Page
    {
        return $this->structureService->copyPage($page);
    }
    
    /**
     *  Save files.
     *
     * @param array $data
     * @return array
     */
    private function saveMedia(array $data) : array
    {
        if (!empty($data['logo_file'])) {
            $data['logo'] = $this->imageService->upload($data['logo_file']);
        }

        return $data;
    }
    
    
}
