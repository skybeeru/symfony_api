<?php


namespace App\Service;


use App\Entity\Fails;
use App\Entity\Image;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;

class ImageProcessor
{
    private $em;
    private $resize;

    public function __construct(EntityManagerInterface $em, Resize $resize)
    {
        $this->em = $em;
        $this->resize = $resize;
    }

    public function process($file,$filename){
        try {
            $resizeService = $this->resize;
            $filesystem = new Filesystem();
            $info = getimagesize($file);
            if(!$info || !in_array($info[2] , [IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP, IMAGETYPE_JPEG2000]))
            {
                throw new \Exception('File is not a picture. ');
            }
            list($width, $height) = $info;
            $file->move(Image::DIR, $filename);
            $filesystem->copy(Image::DIR.$filename,Image::THUMB_DIR.$filename);
            $filesystem->copy(Image::DIR.$filename,Image::SQR_DIR.$filename);
            list($t_width, $t_height) = $resizeService->resize($filename);
            $image = new Image();
            $image->setFilename($filename);
            $image->setWidth($width);
            $image->setHeight($height);
            $image->setTWidth($t_width);
            $image->setTHeight($t_height);
            $this->em->persist($image);
            $this->em->flush();
        } catch (\Exception $e){
            $fail = new Fails();
            $fail->setFilename($filename);
            $fail->setErrorCode($e->getCode());
            $fail->setErrorMsg($e->getMessage());
            $this->em->persist($fail);
            $this->em->flush();
        }
    }
}