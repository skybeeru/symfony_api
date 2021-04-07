<?php


namespace App\Service;

use App\Entity\Fails;
use App\Entity\Image;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Doctrine\ORM\EntityManagerInterface;

class Resize
{
    private const MAX_WIDTH = 400;
    private const MAX_HEIGHT = 400;

    private $imagine;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->imagine = new Imagine();
        $this->em = $em;
    }

    public function resize($filename) : array
    {
        $this->square(Image::SQR_DIR.$filename);
        return $this->thumbnail(Image::THUMB_DIR.$filename);
    }

    /**
     * @param $image
     * @return int[]
     */
    public function thumbnail($image) : array
    {
        try {
            list($iwidth, $iheight) = getimagesize($image);
            $ratio = $iwidth / $iheight;
            $width = self::MAX_WIDTH;
            $height = self::MAX_HEIGHT;
            if ($width / $height > $ratio) {
                $width = $height * $ratio;
            } else {
                $height = $width / $ratio;
            }

            $photo = $this->imagine->open($image);
            $photo->resize(new Box($width, $height))->save($image);
        } catch (\Exception $e){
            $this->failed($image,$e);
        }

        return [$width,$height];
    }

    /**
     * @param $image
     */
    public function square($image) : void
    {
        try {
            $photo = $this->imagine->open($image);
            $photo->resize(new Box(100, 100))->save($image);
        } catch (\Exception $e){
            $this->failed($image,$e);
        }
    }

    protected function failed($image,$e){
        $fail = new Fails();
        $fail->setFilename($image);
        $fail->setErrorCode($e->getCode());
        $fail->setErrorMsg($e->getMessage());
        $this->em->persist($fail);
        $this->em->flush();
    }

}