<?php


namespace AppBundle\Service;


use AppBundle\Entity\Document;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDir;
    private $typeFile;

    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    public function upload(UploadedFile $file)
    {
        $this->typeFile = $file->guessExtension();
        $fileName = md5(uniqid()).'.'.$this->typeFile;
        $file->move($this->targetDir, $fileName);
        return $fileName;
    }

    public function getTargetDir()
    {
        return $this->targetDir;
    }

    public function getTypeFile()
    {
        return $this->typeFile;
    }

    public function removeElement($path)
    {
        if (file_exists($this->targetDir . '/' . $path))
            unlink(new File($this->targetDir . '/' . $path));
    }
}