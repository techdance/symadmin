<?php

namespace App\Entity\Master;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="sym_api_admin_user_master.collaborated_labdetailedcoursehours")
 * @ORM\Entity(repositoryClass="App\Repository\Master\CollaboratedlabdetailedcoursehoursRepository")
 */



class Collaboratedlabdetailedcoursehours
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
     * @ORM\Column(type="integer", name="numberOfCredits", length=20, nullable=true)
     */
    private $numberOfCredits;

    /**
     * @ORM\Column(type="integer", name="numberOfCourseWeeks", length=20, nullable=true)
     */
    private $numberOfCourseWeeks;

    /**
     * @ORM\Column(type="integer", name="courseHoursPerWeek", length=20, nullable=true)
     */
    private $courseHoursPerWeek;

    /**
     * @ORM\Column(type="integer", name="lectureHoursPerWeek", length=20, nullable=true)
     */
    private $lectureHoursPerWeek;

    /**
     * @ORM\Column(type="integer", name="labHoursPerWeek", length=20, nullable=true)
     */
    private $labHoursPerWeek;

    /**
     * @ORM\Column(type="integer", name="independentStudyHoursPerWeek", length=20, nullable=true)
     */
    private $independentStudyHoursPerWeek;

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

    public function getNumberOfCredits(): ?int
    {
        return $this->numberOfCredits;
    }

    public function setNumberOfCredits(?int $numberOfCredits): self
    {
        $this->numberOfCredits = $numberOfCredits;

        return $this;
    }

    public function getNumberOfCourseWeeks(): ?int
    {
        return $this->numberOfCourseWeeks;
    }

    public function setNumberOfCourseWeeks(?int $numberOfCourseWeeks): self
    {
        $this->numberOfCourseWeeks = $numberOfCourseWeeks;

        return $this;
    }

    public function getCourseHoursPerWeek(): ?int
    {
        return $this->courseHoursPerWeek;
    }

    public function setCourseHoursPerWeek(?int $courseHoursPerWeek): self
    {
        $this->courseHoursPerWeek = $courseHoursPerWeek;

        return $this;
    }

    public function getLectureHoursPerWeek(): ?int
    {
        return $this->lectureHoursPerWeek;
    }

    public function setLectureHoursPerWeek(?int $lectureHoursPerWeek): self
    {
        $this->lectureHoursPerWeek = $lectureHoursPerWeek;

        return $this;
    }

    public function getLabHoursPerWeek(): ?int
    {
        return $this->labHoursPerWeek;
    }

    public function setLabHoursPerWeek(?int $labHoursPerWeek): self
    {
        $this->labHoursPerWeek = $labHoursPerWeek;

        return $this;
    }

    public function getIndependentStudyHoursPerWeek(): ?int
    {
        return $this->independentStudyHoursPerWeek;
    }

    public function setIndependentStudyHoursPerWeek(?int $independentStudyHoursPerWeek): self
    {
        $this->independentStudyHoursPerWeek = $independentStudyHoursPerWeek;

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
