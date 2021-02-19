<?php

namespace App\Entity\Master;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="sym_api_admin_user_master.collaborated_labdetailedinstructorqualification")
 * @ORM\Entity(repositoryClass="App\Repository\Master\CollaboratedlabdetailedinstructorqualificationRepository")
 */



class Collaboratedlabdetailedinstructorqualification
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
     * @ORM\Column(type="string", name="instructor1Qualification", length=500, nullable=true)
     */
    private $instructor1Qualification;

    /**
     * @ORM\Column(type="string", name="instructor2Qualification", length=500, nullable=true)
     */
    private $instructor2Qualification;

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

    public function getInstructor1Qualification(): ?string
    {
        return $this->instructor1Qualification;
    }

    public function setInstructor1Qualification(?string $instructor1Qualification): self
    {
        $this->instructor1Qualification = $instructor1Qualification;

        return $this;
    }

    public function getInstructor2Qualification(): ?string
    {
        return $this->instructor2Qualification;
    }

    public function setInstructor2Qualification(?string $instructor2Qualification): self
    {
        $this->instructor2Qualification = $instructor2Qualification;

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
