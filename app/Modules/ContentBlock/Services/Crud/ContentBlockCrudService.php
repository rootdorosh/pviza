<?php 

declare( strict_types = 1 );

namespace App\Modules\ContentBlock\Services\Crud;

use App\Modules\ContentBlock\Models\ContentBlock;
use App\Services\Image\ImageService;

/**
 * Class ContentBlockCrudService
 */
class ContentBlockCrudService
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
     *      
     * @param    array $data
     * @return  ContentBlock
     */
    public function store(array $data): ContentBlock
    { 
        $data = $this->attatchMedia($data);

        return ContentBlock::create($data);
	}

    /*
     *      
     * @param    ContentBlock $contentBlock
     * @param    ContentBlock $data
     * @return  ContentBlock
     */
    public function update(ContentBlock $contentBlock, array $data): ContentBlock
    { 
        $data = $this->attatchMedia($data, $contentBlock);
        $contentBlock->update($data);
        
        return $contentBlock;
    }

    /*
     * @param    ContentBlock $contentBlock
     * @return  void
     */
    public function destroy(ContentBlock $contentBlock): void
    {
        $contentBlock->delete();
    }
    
    /*
     * @param      array $ids
     * @return    void
     */
    public function bulkDestroy(array $ids): void
    {
        ContentBlock::destroy($ids);
    }    
      
    /*
     * @param    array $data
     * @return  array
     */
    public function attatchMedia(array $data): array
    {        
        if (!empty($data['adaptive_image']) && is_array($data['adaptive_image'])) {
            $oldImages = $contentBlock->adaptive_image ?? [];
            $data['adaptive_image'] = $this->imageService->saveAdaptiveImageBase64(
                $data['adaptive_image'], 
                $oldImages
            );
        }
     
        if (!empty($data['image']) && is_array($data['image'])) {
            $oldImage = $contentBlock->image ?? null;
            $data['image'] = $this->imageService->saveFromBase64($data['image']['content'], [
                'name' => $data['image']['name'],
                'oldImage' => $oldImage,
            ]);
        }
        
        return $data;
    }
  
    
}