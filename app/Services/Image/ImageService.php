<?php
declare( strict_types = 1 );

namespace App\Services\Image;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use App\Services\Storage\ImageStorageManager;
use Illuminate\Database\Eloquent\Model;


/**
 * Class ImageService
 * @package App\Services\Image
 */
class ImageService implements ImageManagerInterface
{
    /**
     * @var ImageManager
     */
    private $imageManager;

    /**
     * @var ImageStorageManager
     */
    private $storageManager;
    
    /**
     * @var Repository
     */
    private $configRepository;

    /**
     * ImageService constructor.
     * @param ImageManager        $imageManager
     * @param ImageStorageManager $storageManager
     * @param Repository          $repository
     */
    public function __construct(
        ImageManager $imageManager,
        ImageStorageManager $storageManager,
        Repository $repository
    ) {
        $this->imageManager     = $imageManager;
        $this->storageManager   = $storageManager;
        $this->configRepository = $repository;
    }

    /**
     * @param mixed  $data
     * @param string|null $imageName
     * @return string
     */
    public function save($data, string $imageName = null) : string
    {
        $image = $this->prepareImage($data);

        if (!$imageName) {
            $imageName = md5_file($data);
        }
        
        $filePath = $this->storageManager->save($image->stream()->getContents(), $imageName);

        return $filePath;
    }

    /**
     * @param string $base64Content
     * @param array $options
     * @return string
     */
    public function saveFromBase64(string $base64Content, array $options = []) : string
    {
        return $this->saveFromBinary(
            $this->getFileContentFromBase64($base64Content), 
            $options
        );
        
        if (!empty($options['oldImage'])) {
            $this->removeOldImage($options['oldImage']);
        }
    }
    
    /**
     * @param array $data
     * @param array $oldData
     * @return string
     */
    public function saveAdaptiveImageBase64(array $data, array $oldData = []) : array
    {
        $data = array_to_tree_by_keys($data, '->');
        
        $rand = Str::random(10);
        
        $actualImages = [];
        
        foreach ($data as $size => $params) {
            if (!empty($params['image']) && is_array($params['image'])) {
                $content = $this->getFileContentFromBase64($params['image']['content']);
                
                $data[$size]['image'] = $this->saveFromBinary(
                    $content,
                    ['name' => $params['image']['name'], 'withBasePath' => true]
                );
            }
            $actualImages[] = $data[$size]['image'];
        }
        
        foreach ($oldData as $item) {
            if (!in_array($item['image'], $actualImages)) {
                if (!empty($item['image'])) {
                    $this->removeOldImage($item['image']);
                }
            }
        }
        
        return $data;
    }
    
    /*
     * @param string $file
     * @return void
     */
    public function removeOldImage(string $file)
    {
        // TODO ... removo image and crop resize thumbs
    }
    
    /**
     * @param string $binary
     * @param string $imageName
     * @param array $options
     * @return string
     */
    public function saveFromBinary(string $binary, array $options = []) : string
    {
        $imageName = !empty($options['name']) ? 
            $this->normalizeFilename($options['name']) : md5($binary) . '.png';
        
        $filePath = ImageStorageManager::UPLOAD_PATH . $this->storageManager->save(
            $binary, 
            $imageName,
            $options
        );

        return !empty($options['withBasePath']) 
            ? $filePath 
            : str_replace(ImageStorageManager::UPLOAD_PATH, '', $filePath);
    }
    
    /**
     * @param string $filename
     * @return string
     */
    public function normalizeFilename(string $filename) : string
    {
        $expl = explode('.', $filename);
        $ext = array_pop($expl);
        
        return Str::slug(implode('', $expl)) . '.' . $ext;
    }

   /*
     * @param string $binary
     * @return string
     */
    public function getExtBinary(string $binary): string
    {
        preg_match('/data:image\/(.*?)\;base64/', $binary, $match);
        
        return !empty($match[1]) ? $match[1] : 'jpg';
    }
    
    /**
     * @param string $base64Content
     * @return string
     */
    public function getFileContentFromBase64(string $base64Content) : string
    {
        $expl = explode("base64,", $base64Content);
        
        return base64_decode($expl[1]);
    }
    
    
    /**
     * @param mixed $data
     * @return Image
     */
    private function prepareImage($data) : Image
    {
        $image = $this->imageManager->make($data);

        $resizeData = $this->configRepository->get('image.resize');

        //$image->resize($resizeData[ 'width' ], $resizeData[ 'height' ]);

        return $image;
    }

    /**
     * @param UploadedFile $imageFile
     * @param array $params
     * @return string
     */
    public function upload(UploadedFile $imageFile, array $params = []) : string
    {
        $name = strtolower(Str::random(8));
        
        $fileName = $name . '.' . $imageFile->extension();
        
        return $this->save($imageFile, $fileName);
    }

    /**
     * @param string $path
     * @return mixed
     */
    public function deleteOld(string $path)
    {
        info($path);
    }

    /**
     * @param Model $model
     * @param string $attribute
     * @param array $data
     * @return mixed
     */
    public function attachImage(Model $model, string $attribute, array $data): array
    {
        info($data);
        // image data must be array type
        if (!empty($data[$attribute]) && !is_array($data[$attribute])) {
            unset($data[$attribute]);
            info('aaaaa');
            return $data;
        }
        
        $oldImage = ($model && $model->$attribute) ? $model->$attribute : null;
        $doRemoveImage = null;

        if (!empty($data[$attribute]) && is_array($data[$attribute])) {
            $oldImage = $model->$attribute ?? null;
            $data[$attribute] = $this->saveFromBase64($data[$attribute]['content'], [
                'name' => $data[$attribute]['name'],
                'oldImage' => $oldImage,
            ]);
            $doRemoveImage = $oldImage;
        } elseif (empty($data[$attribute])) {
            $doRemoveImage = $oldImage;
            $data[$attribute] = null;
        } 

        if (!empty($doRemoveImage)) {
            $this->deleteOld($doRemoveImage);
        }
        return $data;
    }
}
