<?php

namespace App\Entity;

use App\Repository\FailsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FailsRepository::class)
 */
class Fails
{
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
    private $error_code;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $error_msg;

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

    public function getErrorCode(): ?int
    {
        return $this->error_code;
    }

    public function setErrorCode(int $error_code): self
    {
        $this->error_code = $error_code;

        return $this;
    }

    public function getErrorMsg(): ?string
    {
        return $this->error_msg;
    }

    public function setErrorMsg(?string $error_msg): self
    {
        $this->error_msg = $error_msg;

        return $this;
    }
}
