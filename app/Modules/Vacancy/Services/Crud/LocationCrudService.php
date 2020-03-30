<?php 

declare( strict_types = 1 );

namespace App\Modules\Vacancy\Services\Crud;

use App\Modules\Vacancy\Models\Location;
use App\Services\SlugService;
use App\Services\Image\ImageService;

/**
 * Class LocationCrudService
 */
class LocationCrudService
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
     * @return  Location
     */
    public function store(array $data): Location
    { 
        $data = $this->attatchMedia($data);   
        $data = $this->slugService->handleLangs($data);
        $location = Location::create($data);
                
        return $location;
	}

    /*
     *      
     * @param    Vacancy $location
     * @param    Location $data
     * @return  Location
     */
    public function update(Location $location, array $data): Location
    { 
        $data = $this->attatchMedia($data, $location);
  
        $data = $this->slugService->handleLangs($data);
        $location->update($data);
                
        return $location;
    }

    /*
     * @param    Location $location
     * @return  void
     */
    public function destroy(Location $location): void
    {
        $location->delete();
    }
    
    /*
     * @param      array $ids
     * @return    void
     */
    public function bulkDestroy(array $ids): void
    {
        Location::destroy($ids);
    }    
      
    /*
     * @param    array $data
     * @param    Location $location
     * @return  array
     */
    public function attatchMedia(array $data, Location $location = null): array
    {     
        $data = $this->imageService->attachImage('image', $data, $location);
        
        return $data;
    }
  

    
}