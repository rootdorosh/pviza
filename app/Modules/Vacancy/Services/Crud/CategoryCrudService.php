<?php 

declare( strict_types = 1 );

namespace App\Modules\Vacancy\Services\Crud;

use App\Modules\Vacancy\Models\Category;
use App\Services\SlugService;
use App\Services\Image\ImageService;

/**
 * Class CategoryCrudService
 */
class CategoryCrudService
{
    /**
     * @var  SlugService
     */
     
    private $slugService;
    /**
     * @var  ImageService
     */
     
    private $imageService;

    /*
    * @param  SlugService $slugService
    * @param  ImageService $imageService
    */
    public function __construct(   
        SlugService $slugService,    
        ImageService $imageService         
    )    
    {    
        $this->slugService = $slugService;    
        $this->imageService = $imageService;        
    }

    /*
     *      
     * @param    array $data
     * @return  Category
     */
    public function store(array $data): Category
    { 
        $data = $this->attatchMedia($data);   
        $data = $this->slugService->handleLangs($data);
        $category = Category::create($data);
                
        return $category;
	}

    /*
     *      
     * @param    Vacancy $category
     * @param    Category $data
     * @return  Category
     */
    public function update(Category $category, array $data): Category
    { 
        $data = $this->attatchMedia($data, $category);
  
        $data = $this->slugService->handleLangs($data);
        $category->update($data);
                
        return $category;
    }

    /*
     * @param    Category $category
     * @return  void
     */
    public function destroy(Category $category): void
    {
        $category->delete();
    }
    
    /*
     * @param      array $ids
     * @return    void
     */
    public function bulkDestroy(array $ids): void
    {
        Category::destroy($ids);
    }    
      
    /*
     * @param    array $data
     * @param    Category $category
     * @return  array
     */
    public function attatchMedia(array $data, Category $category = null): array
    {     
        $data = $this->imageService->attachImage($category, 'image', $data);
        
        return $data;
    }
  

    
}