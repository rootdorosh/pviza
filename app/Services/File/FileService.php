<?php
declare( strict_types = 1 );

namespace App\Services\File;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use App\Services\Storage\FileStorageManager;
use Illuminate\Database\Eloquent\Model;


/**
 * Class FileService
 * @package App\Services\File
 */
class FileService implements FileManagerInterface
{
    /**
     * @var FileStorageManager
     */
    private $storageManager;
    
    /**
     * @var Repository
     */
    private $configRepository;

    /**
     * FileService constructor.
     * @param FileStorageManager $storageManager
     * @param Repository          $repository
     */
    public function __construct(
        FileStorageManager $storageManager,
        Repository $repository
    ) {
        $this->storageManager   = $storageManager;
        $this->configRepository = $repository;
    }

    /**
     * @param UploadedFile $file
     * @param string|null $name
     * @return string
     */
    public function save(UploadedFile $file, string $name = null) : string
    {
        if (!$name) {
            $name = time() . '_' . $file->getClientOriginalName();
        }
        
        $filePath = $this->storageManager->save(file_get_contents($file->getRealPath()), $name);

        return $filePath;
    }    
}
