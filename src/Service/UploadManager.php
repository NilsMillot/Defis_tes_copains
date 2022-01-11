<?php


namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadManager
{

    private $targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function upload(UploadedFile $file)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $newFilename = $originalFilename.'-'.uniqid("" ,false).'.'.$file->guessExtension();
        $file->move(
                 $this->getTargetDirectory(),
                $newFilename
            );

        return $newFilename;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }


}