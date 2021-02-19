<?php

namespace App\Entity\Master;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="sym_api_admin_user_master.collaborated_labdetailedcourseresources")
 * @ORM\Entity(repositoryClass="App\Repository\Master\CollaboratedlabdetailedcourseresourcesRepository")
 */



class Collaboratedlabdetailedcourseresources
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    
    /**
     * @ORM\ManyToOne(targetEntity="FosUser", cascade={"persist"})
     * @ORM\JoinColumn(name="userId", nullable=false, referencedColumnName="id")
     */
    private $userId;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createDate", type="datetime", nullable=true)
     */
    private $createDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="modifiedDate", type="datetime", nullable=true)
     */
    private $modifiedDate;

    /**
     * @ORM\ManyToOne(targetEntity="Collaboratedlabscreenprojectoverview", cascade={"persist"})
     * @ORM\JoinColumn(name="projectId", nullable=false, referencedColumnName="id")
     */
    private $projectId;

    /**
     * @ORM\Column(type="string", name="textbokTitle", length=500, nullable=true)
     */
    private $textbokTitle;

    /**
     * @ORM\Column(type="string", name="publisherName", length=75, nullable=true)
     */
    private $publisherName;

    /**
     * @ORM\Column(type="string", name="author", length=75, nullable=true)
     */
    private $author;

    /**
     * @ORM\Column(type="string", name="isbn", length=75, nullable=true)
     */
    private $isbn;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreateDate(): ?\DateTimeInterface
    {
        return $this->createDate;
    }

    public function setCreateDate(?\DateTimeInterface $createDate): self
    {
        $this->createDate = $createDate;

        return $this;
    }

    public function getModifiedDate(): ?\DateTimeInterface
    {
        return $this->modifiedDate;
    }

    public function setModifiedDate(?\DateTimeInterface $modifiedDate): self
    {
        $this->modifiedDate = $modifiedDate;

        return $this;
    }

    public function getTextbokTitle(): ?string
    {
        return $this->textbokTitle;
    }

    public function setTextbokTitle(?string $textbokTitle): self
    {
        $this->textbokTitle = $textbokTitle;

        return $this;
    }

    public function getPublisherName(): ?string
    {
        return $this->publisherName;
    }

    public function setPublisherName(?string $publisherName): self
    {
        $this->publisherName = $publisherName;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(?string $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getUserId(): ?FosUser
    {
        return $this->userId;
    }

    public function setUserId(?FosUser $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getProjectId(): ?Collaboratedlabscreenprojectoverview
    {
        return $this->projectId;
    }

    public function setProjectId(?Collaboratedlabscreenprojectoverview $projectId): self
    {
        $this->projectId = $projectId;

        return $this;
    }
}
