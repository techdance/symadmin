<?php

namespace App\Entity\Master;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="sym_api_admin_user_master.collaborated_userprofileimage")
 * @ORM\Entity(repositoryClass="App\Repository\Master\CollaboratedUserProfileimageRepository")
 */
class CollaboratedUserProfileimage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer",name="PK_profileImageId")
     */
    private $id;

    /**
     * @ORM\Column(type="integer",name="userId", length=20, nullable=false)
     */
    private $userId;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdOn", type="datetime", nullable=true)
     */
    private $createdOn;

    /**
     * @ORM\Column(type="blob",name="blobData")
     */
    private $blobData;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getCreatedOn(): ?\DateTimeInterface
    {
        return $this->createdOn;
    }

    public function setCreatedOn(?\DateTimeInterface $createdOn): self
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    public function getBlobData()
    {
        return $this->blobData;
    }

    public function setBlobData($blobData): self
    {
        $this->blobData = $blobData;

        return $this;
    } 
}
