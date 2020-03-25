<?php 

declare( strict_types = 1 );

namespace App\Modules\Advantage\Services\Crud;

use App\Modules\Advantage\Models\Advantage;
use App\Services\Image\ImageService;

/**
 * Class AdvantageCrudService
 */
class AdvantageCrudService
{
    /**
     * @var  ImageService
     */
    private $imageService;

    /*
    * @param  ImageService $imageService
    */
    public function __construct(
        ImageService $imageService
    ) 
    {
        $this->imageService = $imageService;
    }

    /*
     * @param    array $data
     * @return  Advantage
     */
    public function store(array $data): Advantage
    { 
        $data = $this->attatchMedia($data);
        $advantage = Advantage::create($data);
        
        return $advantage;
    }

    /*
     * @param    Advantage $advantage
     * @param    Advantage $data
     * @return  Advantage
     */
    public function update(Advantage $advantage, array $data): Advantage
    { 
        $data = $this->attatchMedia($data);
        $advantage->update($data);
        
        return $advantage;
    }

    /*
     * @param    Advantage $advantage
     * @return  void
     */
    public function destroy(Advantage $advantage): void
    {
        $advantage->delete();
    }
    
    /*
     * @param      array $ids
     * @return    void
     */
    public function bulkDestroy(array $ids): void
    {
        Advantage::destroy($ids);
    }    
      
    /*
     * @param    array $data
     * @return  array
     */
    public function attatchMedia(array $data): array
    {    
        if (!empty($data['image_base64'])) {
            $data['image'] = $this->imageService->saveFromBase64($data['image_base64'], [
                'name' => $data['image_name'],
            ]);
        }
        
        return $data;
    }
    
    
}
