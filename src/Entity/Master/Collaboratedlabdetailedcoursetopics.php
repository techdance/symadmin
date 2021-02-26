<?php

namespace App\Entity\Master;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="sym_api_admin_user_master.Collaborated_labdetailed_coursetopics")
 * @ORM\Entity(repositoryClass="App\Repository\Master\CollaboratedlabdetailedcoursetopicsRepository")
 */



class Collaboratedlabdetailedcoursetopics
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
     * @ORM\JoinColumn(name="PK_projectId", nullable=false, referencedColumnName="id")
     */
    private $projectId;

    /**
     * @ORM\Column(type="string", name="courseTopic", length=500, nullable=true)
     */
    private $courseTopic;

    /**
     * @ORM\Column(type="integer", name="PK_courseId", length=20, nullable=true)
     */
    private $courseId;

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

    public function getCourseTopic(): ?string
    {
        return $this->courseTopic;
    }

    public function setCourseTopic(?string $courseTopic): self
    {
        $this->courseTopic = $courseTopic;

        return $this;
    }

    public function getCourseId(): ?int
    {
        return $this->courseId;
    }

    public function setCourseId(?int $courseId): self
    {
        $this->courseId = $courseId;

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
