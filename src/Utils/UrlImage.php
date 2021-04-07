<?php


namespace App\Utils;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UrlImage extends UploadedFile
{
    public function __construct(string $data, string $originalName)
    {
        $filePath = tempnam(sys_get_temp_dir(), 'UploadedFileUrl');
        file_put_contents($filePath, $data);
        $error = null;
        $mimeType = null;
        $test = true;

        parent::__construct($filePath, $originalName, $mimeType, $error, $test);
    }
}