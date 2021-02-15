<?php

namespace App\Entity\Master;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="sym_api_admin_user_master.collaborated_labscreenprojectpartners")
 * @ORM\Entity(repositoryClass="App\Repository\Master\CollaboratedLabScreenProjectPartnersRepository")
 */
class CollaboratedLabScreenProjectPartners
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Master\CollaboratedProfileAreaofInterest")
     * @ORM\JoinColumn(name="interestId", referencedColumnName="id", nullable=true)
     */
    private $interestId;

    /**
     * @ORM\Column(type="integer", name="projectPartnerId", length=20, nullable=true)
     */
    private $projectPartnerId;

    /**
     * @ORM\Column(type="integer", name="isRemoved", length=20, nullable=true)
     */
    private $isActive;

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

    public function getProjectPartnerId(): ?int
    {
        return $this->projectPartnerId;
    }

    public function setProjectPartnerId(?int $projectPartnerId): self
    {
        $this->projectPartnerId = $projectPartnerId;

        return $this;
    }

    public function getIsActive(): ?int
    {
        return $this->isActive;
    }

    public function setIsActive(?int $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getInterestId(): ?CollaboratedProfileAreaofInterest
    {
        return $this->interestId;
    }

    public function setInterestId(?CollaboratedProfileAreaofInterest $interestId): self
    {
        $this->interestId = $interestId;

        return $this;
    }

}
