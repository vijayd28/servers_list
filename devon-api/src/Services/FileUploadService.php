<?php


namespace App\Services;

use Symfony\Component\HttpFoundation\File\Exception\FileException;

class FileUploadService
{
    /**
     * @param $file
     * @return string
     * @throws \Exception
     */
    public function upload($file)
    {
        $fileFolder = __DIR__ . '/../../var/uploads/';

        $filePathName = md5(uniqid()) . $file->getClientOriginalName();
        try {
            $path = $fileFolder. $filePathName;
            $file->move($path);

            return $path;
        } catch (FileException $e) {
            throw new \Exception('Something went wrong when uploading file.');
        }
    }
}