<?php
declare( strict_types = 1 );

namespace App\Services\Faker;

use Illuminate\Support\Arr;
use Faker\Generator as Faker;
use App\Services\Image\ImageService;

/**
 * Class Faker
 * @package App\Services\Faker
 */
class FakerService 
{

    /**
     * @var  ImageService
     */
    private $imageService;

    /**
     * @var  Faker
     */
    private $faker;

    /*
    * @param  ImageService $imageService
    * @param  Faker $imageService
    */
    public function __construct(
        ImageService $imageService,
        Faker $faker
    ) 
    {
        $this->imageService = $imageService;
        $this->faker = $faker;
    }

    /**
     * @param string|null $name
     * @return string
     */
    public function imgPath($name = null, $dir = null) : string
    {
        $binary = $this->getRandomImageContent($dir);
        if ($name === null) {
            $name = $this->faker->word();
        }
        $name .= '.' . $this->imageService->getExtBinary($binary);
        
        $path = $this->imageService->saveFromBinary(
            $binary, 
            compact('name')
        );
        
        return $path;
    }

    /**
     * @return string
     */
    public function getRandomImageContent(string $dir = null) : string
    {
        return file_get_contents(
            Arr::random(
                glob($this->getImgPath($dir) . '/*')
            )
        );
    }

    
    /**
     * @return string
     */
    public function getPath() : string
    {
        return resource_path() . '/faker';
    }

    /**
     * @return string
     */
    public function getImgPath(string $dir = null) : string
    {
        $path = $this->getPath() . '/img';
        if ($dir) {
            $path .= '/' . $dir;
        }
        return $path;
    }
    
    /**
     * @return string
     */
    public function svg() : string
    {
        $icons = [
            '  <symbol id="close" viewBox="0 0 14.2 14.2">
                <path d="M8.5,7.1l5.4-5.4c0.4-0.4,0.4-1,0-1.4s-1-0.4-1.4,0L7.1,5.7L1.7,0.3c-0.4-0.4-1-0.4-1.4,0s-0.4,1,0,1.4l5.4,5.4
               l-5.4,5.4c-0.4,0.4-0.4,1,0,1.4c0.2,0.2,0.5,0.3,0.7,0.3s0.5-0.1,0.7-0.3l5.4-5.4l5.4,5.4c0.2,0.2,0.5,0.3,0.7,0.3s0.5-0.1,0.7-0.3
               c0.4-0.4,0.4-1,0-1.4L8.5,7.1z"/> 
            </symbol>',  
            '<symbol id="facebook" viewBox="0 0 25 25">
               <g> <path d="M21.3,0H3.7C1.6,0,0,1.6,0,3.7v17.7c0,2,1.6,3.7,3.7,3.7H11v-8.9H8.1v-4.4H11V8.8c0-1.6,0.9-3,2.2-3.8
                  c0.6-0.4,1.4-0.6,2.2-0.6h4.4v4.4h-4.4v2.9h4.4l-0.7,4.4h-3.7V25h5.9c2,0,3.7-1.6,3.7-3.7V3.7C25,1.6,23.4,0,21.3,0z"/> 
                  <path fill="#FFFFFF" d="M19.1,16.1l0.7-4.4h-4.4V8.8h4.4V4.4h-4.4c-0.8,0-1.6,0.2-2.2,0.6C11.9,5.7,11,7.2,11,8.8v2.9H8.1v4.4H11V25
                  h4.4v-8.9H19.1z"/> </g> 
            </symbol>',
            '<symbol id="windows" viewBox="0 0 30 30">
               <polygon points="13.6,27.7 30,30 30,15.6 13.6,15.6 "/> <polygon points="13.6,2.4 13.6,14.4 30,14.4 30,0 "/> <polygon points="0,14.4 12.5,14.4 12.5,2.5 0,4.2 "/> <polygon points="0,25.9 12.5,27.5 12.5,15.6 0,15.6 "/> 
            </symbol>',
            '<symbol id="youtube" viewBox="0 0 32 24.4">
               <g> <path d="M27.3,0H4.7C2.1,0,0,2.1,0,4.7v15c0,2.6,2.1,4.7,4.7,4.7h22.6c2.6,0,4.7-2.1,4.7-4.7v-15C32,2.1,29.9,0,27.3,0
                  z M16,16l-4.7,2.7V5.9L16,8.5l6.6,3.7L16,16z"/> <polygon fill="#FFFFFF" points="11.3,5.9 11.3,18.7 16,16 22.6,12.2 16,8.5"/> </g> 
            </symbol>',            
        ];
        
        return $this->faker->randomElement($icons);
    }
    
}
