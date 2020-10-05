<?php

namespace App\Entity;

use App\Repository\DocumentsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DocumentsRepository::class)
 */
class Documents
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $sub_category;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * maxSize = "5000k",
     */
    private $file_type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $file_url;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getSubCategory(): ?string
    {
        return $this->sub_category;
    }

    public function setSubCategory(?string $sub_category): self
    {
        $this->sub_category = $sub_category;

        return $this;
    }

    public function getFileType(): ?string
    {
        return $this->file_type;
    }

    public function setFileType(?string $file_type): self
    {
        $this->file_type = $file_type;

        return $this;
    }

    public function getFileUrl(): ?string
    {
        return $this->file_url;
    }

    public function setFileUrl(?string $file_url): self
    {
        $this->file_url = $file_url;

        return $this;
    }
}
