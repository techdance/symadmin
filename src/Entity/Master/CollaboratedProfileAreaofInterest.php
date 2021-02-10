<?php

namespace App\Entity\Master;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="sym_api_admin_user_master.collaborated_profileareaofinterest")
 * @ORM\Entity(repositoryClass="App\Repository\Master\CollaboratedProfileAreaofInterestRepository")
 */
class CollaboratedProfileAreaofInterest
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
     * @ORM\Column(type="string", name="projectType", length=75, nullable=true)
     */
    private $projectType;

    /**
     * @ORM\Column(type="string", name="description", length=250, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", name="discipline1", length=75, nullable=true)
     */
    private $disciplineA;

    /**
     * @ORM\Column(type="string", name="language", length=75, nullable=true)
     */
    private $language;

    /**
     * @ORM\Column(type="string", name="location1", length=75, nullable=true)
     */
    private $locationA;

    /**
     * @ORM\Column(type="string", name="campus", length=75, nullable=true)
     */
    private $campus;

    /**
     * @ORM\Column(type="string", name="programLevel", length=75, nullable=true)
     */
    private $programLevel;

    /**
     * @ORM\Column(type="string", name="programLength", length=75, nullable=true)
     */
    private $programLength;

    /**
     * @ORM\Column(type="string", name="deliveryMethod", length=75, nullable=true)
     */
    private $deliveryMethod;

    /**
     * @ORM\Column(type="string", name="credits", length=75, nullable=true)
     */
    private $credits;

    /**
     * @ORM\Column(type="string", name="collaborationType", length=75, nullable=true)
     */
    private $collaborationType;

    /**
     * @ORM\Column(type="string", name="discipline2", length=100, nullable=true)
     */
    private $disciplineB;

    /**
     * @ORM\Column(type="string", name="location2", length=100, nullable=true)
     */
    private $locationB;

    /**
     * @ORM\Column(type="string", name="discipline3", length=100, nullable=true)
     */
    private $disciplineC;

    /**
     * @ORM\Column(type="string", name="location3", length=100, nullable=true)
     */
    private $locationC;

    /**
     * @ORM\Column(type="string", name="discipline4", length=100, nullable=true)
     */
    private $disciplineD;

    /**
     * @ORM\Column(type="string", name="location4", length=100, nullable=true)
     */
    private $locationD;

    /**
     * @ORM\Column(type="string", name="rangeYearStart", length=20, nullable=true)
     */
    private $rangeYearStart;

    /**
     * @ORM\Column(type="string", name="rangeYearEnd", length=20, nullable=true)
     */
    private $rangeYearEnd;

    /**
     * @ORM\Column(type="string", name="rangeMonthStart", length=75, nullable=true)
     */
    private $rangeMonthStart;

    /**
     * @ORM\Column(type="string", name="rangeMonthEnd", length=75, nullable=true)
     */
    private $rangeMonthEnd;

    /**
     * @ORM\Column(type="string", name="universityName", length=75, nullable=true)
     */
    private $universityName;

    /**
     * @ORM\Column(type="string", name="groupName", length=75, nullable=true)
     */
    private $groupName;

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

    public function getProjectType(): ?string
    {
        return $this->projectType;
    }

    public function setProjectType(?string $projectType): self
    {
        $this->projectType = $projectType;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDisciplineA(): ?string
    {
        return $this->disciplineA;
    }

    public function setDisciplineA(?string $disciplineA): self
    {
        $this->disciplineA = $disciplineA;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(?string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getLocationA(): ?string
    {
        return $this->locationA;
    }

    public function setLocationA(?string $locationA): self
    {
        $this->locationA = $locationA;

        return $this;
    }

    public function getCampus(): ?string
    {
        return $this->campus;
    }

    public function setCampus(?string $campus): self
    {
        $this->campus = $campus;

        return $this;
    }

    public function getProgramLevel(): ?string
    {
        return $this->programLevel;
    }

    public function setProgramLevel(?string $programLevel): self
    {
        $this->programLevel = $programLevel;

        return $this;
    }

    public function getProgramLength(): ?string
    {
        return $this->programLength;
    }

    public function setProgramLength(?string $programLength): self
    {
        $this->programLength = $programLength;

        return $this;
    }

    public function getDeliveryMethod(): ?string
    {
        return $this->deliveryMethod;
    }

    public function setDeliveryMethod(?string $deliveryMethod): self
    {
        $this->deliveryMethod = $deliveryMethod;

        return $this;
    }

    public function getCredits(): ?string
    {
        return $this->credits;
    }

    public function setCredits(?string $credits): self
    {
        $this->credits = $credits;

        return $this;
    }

    public function getCollaborationType(): ?string
    {
        return $this->collaborationType;
    }

    public function setCollaborationType(?string $collaborationType): self
    {
        $this->collaborationType = $collaborationType;

        return $this;
    }

    public function getDisciplineB(): ?string
    {
        return $this->disciplineB;
    }

    public function setDisciplineB(?string $disciplineB): self
    {
        $this->disciplineB = $disciplineB;

        return $this;
    }

    public function getLocationB(): ?string
    {
        return $this->locationB;
    }

    public function setLocationB(?string $locationB): self
    {
        $this->locationB = $locationB;

        return $this;
    }

    public function getDisciplineC(): ?string
    {
        return $this->disciplineC;
    }

    public function setDisciplineC(?string $disciplineC): self
    {
        $this->disciplineC = $disciplineC;

        return $this;
    }

    public function getLocationC(): ?string
    {
        return $this->locationC;
    }

    public function setLocationC(?string $locationC): self
    {
        $this->locationC = $locationC;

        return $this;
    }

    public function getDisciplineD(): ?string
    {
        return $this->disciplineD;
    }

    public function setDisciplineD(?string $disciplineD): self
    {
        $this->disciplineD = $disciplineD;

        return $this;
    }

    public function getLocationD(): ?string
    {
        return $this->locationD;
    }

    public function setLocationD(?string $locationD): self
    {
        $this->locationD = $locationD;

        return $this;
    }

    public function getRangeYearStart(): ?string
    {
        return $this->rangeYearStart;
    }

    public function setRangeYearStart(?string $rangeYearStart): self
    {
        $this->rangeYearStart = $rangeYearStart;

        return $this;
    }

    public function getRangeYearEnd(): ?string
    {
        return $this->rangeYearEnd;
    }

    public function setRangeYearEnd(?string $rangeYearEnd): self
    {
        $this->rangeYearEnd = $rangeYearEnd;

        return $this;
    }

    public function getRangeMonthStart(): ?string
    {
        return $this->rangeMonthStart;
    }

    public function setRangeMonthStart(?string $rangeMonthStart): self
    {
        $this->rangeMonthStart = $rangeMonthStart;

        return $this;
    }

    public function getRangeMonthEnd(): ?string
    {
        return $this->rangeMonthEnd;
    }

    public function setRangeMonthEnd(?string $rangeMonthEnd): self
    {
        $this->rangeMonthEnd = $rangeMonthEnd;

        return $this;
    }

    public function getUniversityName(): ?string
    {
        return $this->universityName;
    }

    public function setUniversityName(?string $universityName): self
    {
        $this->universityName = $universityName;

        return $this;
    }

    public function getGroupName(): ?string
    {
        return $this->groupName;
    }

    public function setGroupName(?string $groupName): self
    {
        $this->groupName = $groupName;

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


}
