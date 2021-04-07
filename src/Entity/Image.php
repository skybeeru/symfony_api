<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 */
class Image
{
    const DIR = 'images/';
    const THUMB_DIR = 'images/tmb/';
    const SQR_DIR = 'images/sqr/';
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * @ORM\Column(type="integer")
     */
    private $width;

    /**
     * @ORM\Column(type="integer")
     */
    private $height;

    /**
     * @ORM\Column(type="integer")
     */
    private $t_width;

    /**
     * @ORM\Column(type="integer")
     */
    private $t_height;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(int $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(int $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getTWidth(): ?int
    {
        return $this->t_width;
    }

    public function setTWidth(int $t_width): self
    {
        $this->t_width = $t_width;

        return $this;
    }

    public function getTHeight(): ?int
    {
        return $this->t_height;
    }

    public function setTHeight(int $t_height): self
    {
        $this->t_height = $t_height;

        return $this;
    }
}
