<?php 

declare( strict_types = 1 );

namespace App\Modules\Blog\Services\Crud;

use App\Modules\Blog\Models\Blog;
use App\Services\Image\ImageService;

/**
 * Class BlogCrudService
 */
class BlogCrudService
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
     * @return  Blog
     */
    public function store(array $data): Blog
    { 
        $data = $this->attatchMedia($data);          $blog = Blog::create($data);
                
        return $blog;
	}

    /*
     *      
     * @param    Blog $blog
     * @param    Blog $data
     * @return  Blog
     */
    public function update(Blog $blog, array $data): Blog
    { 
        $data = $this->attatchMedia($data, $blog);
         $blog->update($data);
                
        return $blog;
    }

    /*
     * @param    Blog $blog
     * @return  void
     */
    public function destroy(Blog $blog): void
    {
        $blog->delete();
    }
    
    /*
     * @param      array $ids
     * @return    void
     */
    public function bulkDestroy(array $ids): void
    {
        Blog::destroy($ids);
    }    
      
    /*
     * @param    array $data
     * @param    Blog $blog
     * @return  array
     */
    public function attatchMedia(array $data, Blog $blog = null): array
    {     
        $data = $this->imageService->attachImage('image', $data, $blog);
    
        $data = $this->imageService->attachImage('image_header', $data, $blog);
        
        return $data;
    }
  

    
}