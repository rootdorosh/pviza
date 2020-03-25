<?php 

declare( strict_types = 1 );

namespace App\Modules\ContentBlock\Services\Crud\ContentBlock;

use App\Modules\ContentBlock\Models\ContentBlock;
use App\Modules\ContentBlock\Models\ContentBlock\Photo;
use App\Services\Image\ImageService;

/**
 * Class PhotoCrudService
 */
class PhotoCrudService
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
     * @param      ContentBlock $contentBlock     
     * @param    array $data
     * @return  Photo
     */
    public function store(ContentBlock $contentBlock, array $data): Photo
    { 
        $data = $this->attatchMedia($data);
        $data['rank'] = (int) Photo::where('content_block_id', $contentBlock->id)->max('rank') + 1;
        
        return $contentBlock->photos()->save(new Photo($data));
	}

    /*
     *      
     * @param      ContentBlock $contentBlock     
     * @param    ContentBlock $photo
     * @param    Photo $data
     * @return  Photo
     */
    public function update(ContentBlock $contentBlock, Photo $photo, array $data): Photo
    { 
        $data = $this->attatchMedia($data, $photo);
        $photo->update($data);
        
        return $photo;
    }

    /*
     * @param    Photo $photo
     * @return  void
     */
    public function destroy(Photo $photo): void
    {
        $photo->delete();
    }
    
    /*
     * @param      array $ids
     * @return    void
     */
    public function bulkDestroy(array $ids): void
    {
        Photo::destroy($ids);
    }    
      
    /*
     * @param    array $data
     * @return  array
     */
    public function attatchMedia(array $data): array
    {     
        if (!empty($data['image']) && is_array($data['image'])) {
            $oldImage = $photo->image ?? null;
            $data['image'] = $this->imageService->saveFromBase64($data['image']['content'], [
                'name' => $data['image']['name'],
                'oldImage' => $oldImage,
            ]);
        }
        
        return $data;
    }
  
    /**
     * Sortable photos
     *
     * @param  array $ids
     * @return  void
     */
    public function sortable(array $ids) : void
    {
        foreach ($ids as $rank => $id) {
            $photo = Photo::where('id', $id)->first();
            if (!empty($photo)) {
                $photo->update(['rank' => $rank]);
            }
        }
    }
    
}