<?php
declare( strict_types = 1 );

namespace App\Services\File;

use Illuminate\Http\UploadedFile;

/**
 * Interface FileManagerInterface
 * @package App\Services\File
 */
interface FileManagerInterface
{
    /**
     * @param UploadedFile $file
     * @param string       $name
     * @return string
     */
    public function save(UploadedFile $file, string $name = null) : string;
}
