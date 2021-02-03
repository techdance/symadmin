<?php

namespace App\Entity\Master;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="sym_api_admin_user_master.collaborated_usercredential")
 * @ORM\Entity(repositoryClass="App\Repository\Master\CollaboratedusercredentialRepository")
 */
class Collaboratedusercredential
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
     * @ORM\Column(type="string", name="membership1", length=75, nullable=true)
     */
    private $membership1;

    /**
     * @ORM\Column(type="string", name="membership2", length=75, nullable=true)
     */
    private $membership2;

    /**
     * @ORM\Column(type="string", name="membership3", length=75, nullable=true)
     */
    private $membership3;

    /**
     * @ORM\Column(type="string", name="educationallevel", length=75, nullable=true)
     */
    private $educationallevel;

    /**
     * @ORM\Column(type="string", name="certificate1", length=75, nullable=true)
     */
    private $certificate1;

    /**
     * @ORM\Column(type="string", name="certificate2", length=75, nullable=true)
     */
    private $certificate2;

    /**
     * @ORM\Column(type="string", name="certificate3", length=75, nullable=true)
     */
    private $certificate3;

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

    public function getMembership1(): ?string
    {
        return $this->membership1;
    }

    public function setMembership1(?string $membership1): self
    {
        $this->membership1 = $membership1;

        return $this;
    }

    public function getMembership2(): ?string
    {
        return $this->membership2;
    }

    public function setMembership2(?string $membership2): self
    {
        $this->membership2 = $membership2;

        return $this;
    }

    public function getMembership3(): ?string
    {
        return $this->membership3;
    }

    public function setMembership3(?string $membership3): self
    {
        $this->membership3 = $membership3;

        return $this;
    }

    public function getEducationallevel(): ?string
    {
        return $this->educationallevel;
    }

    public function setEducationallevel(?string $educationallevel): self
    {
        $this->educationallevel = $educationallevel;

        return $this;
    }

    public function getCertificate1(): ?string
    {
        return $this->certificate1;
    }

    public function setCertificate1(?string $certificate1): self
    {
        $this->certificate1 = $certificate1;

        return $this;
    }

    public function getCertificate2(): ?string
    {
        return $this->certificate2;
    }

    public function setCertificate2(?string $certificate2): self
    {
        $this->certificate2 = $certificate2;

        return $this;
    }

    public function getCertificate3(): ?string
    {
        return $this->certificate3;
    }

    public function setCertificate3(?string $certificate3): self
    {
        $this->certificate3 = $certificate3;

        return $this;
    }
}
