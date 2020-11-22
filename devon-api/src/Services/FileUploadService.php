<?php


namespace App\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * @property  targetDirectory
 */
class FileUploadService
{

    /**
     * @var $targetDirectory
     */
    private $targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    /**
     * @param $file
     * @return string
     * @throws \Exception
     */
    public function upload(UploadedFile $file)
    {
        $filePathName = md5(uniqid()) . $file->getClientOriginalName();
        try {
            $path = $this->targetDirectory. '/'. $filePathName;
            $file->move($path);

            return $filePathName;
        } catch (FileException $e) {
            throw new \Exception('Something went wrong when uploading file.');
        }
    }
}