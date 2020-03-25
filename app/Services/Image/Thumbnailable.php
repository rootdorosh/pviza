<?php

namespace App\Services\Image;

use App;
use App\Services\Storage\ImageStorageManager;

trait Thumbnailable
{
    /**
     * Get image thumb
     *
     * @param  string $attribute
     * @param  int|null $width
     * @param  int|null $height
     * @param  string $mode
     * @return string|null
     */
    public function getThumb(string $attribute = 'image', int $width = null, $height = null, string $mode = 'resize'): ? string
    {
        //$siteUrl = config('app.url');
        $siteUrl = '';
//        
        if (!empty($this->$attribute)) {
            $image = $this->$attribute;
            $width = $width === 0 ? $height : $width;
            $height = $height === 0 ? $width : $height;
            
            $expl = explode('.', $image);

            if (end($expl) == 'svg' || (!$width && !$height)) {
                return $siteUrl . ImageStorageManager::UPLOAD_PATH . $image;
            }

            $basePath = public_path() . ImageStorageManager::UPLOAD_PATH;
            if (!is_file($basePath . $image)) {
                return null;
            }
                
            $pathInfo = pathinfo($basePath . $image);
            
            $pos = strrpos($image, "/");
            $fileMode = $mode == 'resize' ? 'r' : 'c';

            $thumbName = substr($image, 0, $pos) . '/' . $pathInfo['filename'] . '-' .
                $fileMode . '_' . $width . 'x' . $height . '.' . $pathInfo['extension'];
            
            if (!is_file($basePath . $thumbName)) {
                $imageManager = App::make('Intervention\Image\ImageManager');
                
                $thumb = $imageManager->make($basePath . $image);
                
                if ($mode == 'resize') {
                    $thumb->resize($width, $height);
                } else {
                    $thumb->crop($width, $height);
                }
                
                $thumb->save($basePath . $thumbName);
            }
            
            return $siteUrl . ImageStorageManager::UPLOAD_PATH . $thumbName;
        }

        return null;
    }
}
