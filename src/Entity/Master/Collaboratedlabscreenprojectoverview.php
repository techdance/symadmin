<?php

namespace App\Entity\Master;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="sym_api_admin_user_master.collaborated_labscreenprojectoverview")
 * @ORM\Entity(repositoryClass="App\Repository\Master\CollaboratedlabscreenprojectoverviewRepository")
 */
class Collaboratedlabscreenprojectoverview
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
     * @ORM\Column(type="integer", name="projectOwnedId", length=20, nullable=true)
     */
    private $projectOwnedId;

    /**
     * @ORM\Column(type="string", name="projectDescription", length=1000, nullable=true)
     */
    private $projectDescription;

    /**
     * @ORM\Column(type="string", name="projectName", length=500, nullable=true)
     */
    private $projectName;

    /**
     * @ORM\Column(type="string", name="projectType", length=75, nullable=true)
     */
    private $projectType;

    /**
     * @ORM\Column(type="string", name="projectDiscipline1", length=75, nullable=true)
     */
    private $projectDiscipline1;

    /**
     * @ORM\Column(type="string", name="projectDiscipline2", length=75, nullable=true)
     */
    private $projectDiscipline2;

    /**
     * @ORM\Column(type="string", name="projectDiscipline3", length=75, nullable=true)
     */
    private $projectDiscipline3;

    /**
     * @ORM\Column(type="string", name="role", length=75, nullable=true)
     */
    private $role;

    /**
     * @ORM\Column(type="datetime", name="projectStartDate", length=75, nullable=true)
     */
    private $projectStartDate;

    /**
     * @ORM\Column(type="datetime", name="projectEndDate", length=75, nullable=true)
     */
    private $projectEndDate;

    /**
     * @ORM\Column(type="integer", name="projectDocumentId", length=20, nullable=true)
     */
    private $projectDocumentId;

    /**
     * @ORM\Column(type="string", name="percentage", length=20, nullable=true)
     */
    private $percentage;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Master\CollaboratedProfileAreaofInterest")
     * @ORM\JoinColumn(name="interestId", referencedColumnName="id", nullable=true)
     */
    private $interestId;

    /**
     * @ORM\Column(type="string", name="projectStatus", length=75, nullable=true)
     */
    private $projectStatus;

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

    public function getProjectOwnedId(): ?int
    {
        return $this->projectOwnedId;
    }

    public function setProjectOwnedId(?int $projectOwnedId): self
    {
        $this->projectOwnedId = $projectOwnedId;

        return $this;
    }

    public function getProjectDescription(): ?string
    {
        return $this->projectDescription;
    }

    public function setProjectDescription(?string $projectDescription): self
    {
        $this->projectDescription = $projectDescription;

        return $this;
    }

    public function getProjectName(): ?string
    {
        return $this->projectName;
    }

    public function setProjectName(?string $projectName): self
    {
        $this->projectName = $projectName;

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

    public function getProjectDiscipline1(): ?string
    {
        return $this->projectDiscipline1;
    }

    public function setProjectDiscipline1(?string $projectDiscipline1): self
    {
        $this->projectDiscipline1 = $projectDiscipline1;

        return $this;
    }

    public function getProjectDiscipline2(): ?string
    {
        return $this->projectDiscipline2;
    }

    public function setProjectDiscipline2(?string $projectDiscipline2): self
    {
        $this->projectDiscipline2 = $projectDiscipline2;

        return $this;
    }

    public function getProjectDiscipline3(): ?string
    {
        return $this->projectDiscipline3;
    }

    public function setProjectDiscipline3(?string $projectDiscipline3): self
    {
        $this->projectDiscipline3 = $projectDiscipline3;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getProjectStartDate(): ?\DateTimeInterface
    {
        return $this->projectStartDate;
    }

    public function setProjectStartDate(?\DateTimeInterface $projectStartDate): self
    {
        $this->projectStartDate = $projectStartDate;

        return $this;
    }

    public function getProjectEndDate(): ?\DateTimeInterface
    {
        return $this->projectEndDate;
    }

    public function setProjectEndDate(?\DateTimeInterface $projectEndDate): self
    {
        $this->projectEndDate = $projectEndDate;

        return $this;
    }

    public function getProjectDocumentId(): ?int
    {
        return $this->projectDocumentId;
    }

    public function setProjectDocumentId(?int $projectDocumentId): self
    {
        $this->projectDocumentId = $projectDocumentId;

        return $this;
    }

    public function getPercentage(): ?string
    {
        return $this->percentage;
    }

    public function setPercentage(?string $percentage): self
    {
        $this->percentage = $percentage;

        return $this;
    }

    public function getProjectStatus(): ?string
    {
        return $this->projectStatus;
    }

    public function setProjectStatus(?string $projectStatus): self
    {
        $this->projectStatus = $projectStatus;

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
