<?php

namespace App\Entity\Master;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="sym_api_admin_user_master.collaborated_labdetailedcourseidentification")
 * @ORM\Entity(repositoryClass="App\Repository\Master\CollaboratedlabdetailedcourseidentificationRepository")
 */
class Collaboratedlabdetailedcourseidentification
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
     * @ORM\Column(type="string", name="courseTitle", length=200, nullable=true)
     */
    private $courseTitle;

    /**
     * @ORM\Column(type="string", name="courseNumber", length=75, nullable=true)
     */
    private $courseNumber;

    /**
     * @ORM\Column(type="string", name="prerequisites", length=75, nullable=true)
     */
    private $prerequisites;

    /**
     * @ORM\Column(type="string", name="courseDescription", length=1000, nullable=true)
     */
    private $courseDescription;

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

    public function getCourseTitle(): ?string
    {
        return $this->courseTitle;
    }

    public function setCourseTitle(?string $courseTitle): self
    {
        $this->courseTitle = $courseTitle;

        return $this;
    }

    public function getCourseNumber(): ?string
    {
        return $this->courseNumber;
    }

    public function setCourseNumber(?string $courseNumber): self
    {
        $this->courseNumber = $courseNumber;

        return $this;
    }

    public function getPrerequisites(): ?string
    {
        return $this->prerequisites;
    }

    public function setPrerequisites(?string $prerequisites): self
    {
        $this->prerequisites = $prerequisites;

        return $this;
    }

    public function getCourseDescription(): ?string
    {
        return $this->courseDescription;
    }

    public function setCourseDescription(?string $courseDescription): self
    {
        $this->courseDescription = $courseDescription;

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
