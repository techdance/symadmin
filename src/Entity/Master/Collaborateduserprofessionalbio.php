<?php

namespace App\Entity\Master;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="sym_api_admin_user_master.collaborated_userprofessionalbio")
 * @ORM\Entity(repositoryClass="App\Repository\Master\CollaborateduserprofessionalbioRepository")
 */
class Collaborateduserprofessionalbio
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer",name="userId", length=20, nullable=false)
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
     * @ORM\Column(type="string", name="areaofexpertise1", length=75, nullable=true)
     */
    private $areaofexpertiseA;

    /**
     * @ORM\Column(type="string", name="areaofexpertise2", length=75, nullable=true)
     */
    private $areaofexpertiseB;

    /**
     * @ORM\Column(type="string", name="areaofexpertise3", length=75, nullable=true)
     */
    private $areaofexpertiseC;

    /**
     * @ORM\Column(type="string", name="experienceyears", length=75, nullable=true)
     */
    private $experienceyears;

    /**
     * @ORM\Column(type="string", name="cvlink", length=75, nullable=true)
     */
    private $cvlink;

    /**
     * @ORM\Column(type="string", name="certificate2", length=500, nullable=true)
     */
    private $biodescription;

    /**
     * @ORM\Column(type="string", name="certificate3", length=75, nullable=true)
     */
    private $bioDiscipline;

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

    public function getAreaofexpertiseA(): ?string
    {
        return $this->areaofexpertiseA;
    }

    public function setAreaofexpertiseA(?string $areaofexpertiseA): self
    {
        $this->areaofexpertiseA = $areaofexpertiseA;

        return $this;
    }

    public function getAreaofexpertiseB(): ?string
    {
        return $this->areaofexpertiseB;
    }

    public function setAreaofexpertiseB(?string $areaofexpertiseB): self
    {
        $this->areaofexpertiseB = $areaofexpertiseB;

        return $this;
    }

    public function getAreaofexpertiseC(): ?string
    {
        return $this->areaofexpertiseC;
    }

    public function setAreaofexpertiseC(?string $areaofexpertiseC): self
    {
        $this->areaofexpertiseC = $areaofexpertiseC;

        return $this;
    }

    public function getExperienceyears(): ?string
    {
        return $this->experienceyears;
    }

    public function setExperienceyears(?string $experienceyears): self
    {
        $this->experienceyears = $experienceyears;

        return $this;
    }

    public function getCvlink(): ?string
    {
        return $this->cvlink;
    }

    public function setCvlink(?string $cvlink): self
    {
        $this->cvlink = $cvlink;

        return $this;
    }

    public function getBiodescription(): ?string
    {
        return $this->biodescription;
    }

    public function setBiodescription(?string $biodescription): self
    {
        $this->biodescription = $biodescription;

        return $this;
    }

    public function getBioDiscipline(): ?string
    {
        return $this->bioDiscipline;
    }

    public function setBioDiscipline(?string $bioDiscipline): self
    {
        $this->bioDiscipline = $bioDiscipline;

        return $this;
    }
}
