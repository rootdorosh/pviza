<?php 

declare( strict_types = 1 );

namespace App\Modules\Vacancy\Services\Crud;

use App\Modules\Vacancy\Models\Type;
use App\Services\SlugService;
use App\Services\Image\ImageService;

/**
 * Class TypeCrudService
 */
class TypeCrudService
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
     * @return  Type
     */
    public function store(array $data): Type
    { 
        $data = $this->attatchMedia($data);   
        $data = $this->slugService->handleLangs($data);
        $type = Type::create($data);
                
        return $type;
	}

    /*
     *      
     * @param    Vacancy $type
     * @param    Type $data
     * @return  Type
     */
    public function update(Type $type, array $data): Type
    { 
        $data = $this->attatchMedia($data, $type);
  
        $data = $this->slugService->handleLangs($data);
        $type->update($data);
                
        return $type;
    }

    /*
     * @param    Type $type
     * @return  void
     */
    public function destroy(Type $type): void
    {
        $type->delete();
    }
    
    /*
     * @param      array $ids
     * @return    void
     */
    public function bulkDestroy(array $ids): void
    {
        Type::destroy($ids);
    }    
      
    /*
     * @param    array $data
     * @param    Type $type
     * @return  array
     */
    public function attatchMedia(array $data, Type $type = null): array
    {     
        $data = $this->imageService->attachImage($type, 'image', $data);
        
        return $data;
    }
  

    
}