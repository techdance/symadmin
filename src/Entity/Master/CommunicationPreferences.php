<?php

namespace App\Entity\Master;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="sym_api_admin_user_master.collaborated_communicationpreferences")
 * @ORM\Entity(repositoryClass="App\Repository\Master\CommunicationPreferencesRepository")
 */
class CommunicationPreferences
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
     * @ORM\Column(type="integer",name="primaryLanguageId", length=20, nullable=true)
     */
    private $primaryLanguageId;

    /**
     * @ORM\Column(type="string", name="primaryLanguageName", length=75, nullable=true)
     */
    private $primaryLanguageName;

    /**
     * @ORM\Column(type="integer",name="secondaryLanguageId", length=20, nullable=true)
     */
    private $secondaryLanguageId;

    /**
     * @ORM\Column(type="string", name="secondaryLanguageName", length=75, nullable=true)
     */
    private $secondaryLanguageName;

    /**
     * @ORM\Column(type="integer",name="tertiaryLanguageId", length=20, nullable=true)
     */
    private $tertiaryLanguageId;

    /**
     * @ORM\Column(type="string", name="tertiaryLanguageName", length=75, nullable=true)
     */
    private $tertiaryLanguageName;

    /**
     * @ORM\Column(type="string", name="emailAddress", length=75, nullable=true)
     */
    private $emailAddress;

    /**
     * @ORM\Column(type="string", name="phoneNumber", length=75, nullable=true)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", name="website", length=75, nullable=true)
     */
    private $website;

    /**
     * @ORM\Column(type="string", name="mobileNumber", length=75, nullable=true)
     */
    private $mobileNumber;

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

    public function getPrimaryLanguageId(): ?int
    {
        return $this->primaryLanguageId;
    }

    public function setPrimaryLanguageId(?int $primaryLanguageId): self
    {
        $this->primaryLanguageId = $primaryLanguageId;

        return $this;
    }

    public function getPrimaryLanguageName(): ?string
    {
        return $this->primaryLanguageName;
    }

    public function setPrimaryLanguageName(?string $primaryLanguageName): self
    {
        $this->primaryLanguageName = $primaryLanguageName;

        return $this;
    }

    public function getSecondaryLanguageId(): ?int
    {
        return $this->secondaryLanguageId;
    }

    public function setSecondaryLanguageId(?int $secondaryLanguageId): self
    {
        $this->secondaryLanguageId = $secondaryLanguageId;

        return $this;
    }

    public function getSecondaryLanguageName(): ?string
    {
        return $this->secondaryLanguageName;
    }

    public function setSecondaryLanguageName(?string $secondaryLanguageName): self
    {
        $this->secondaryLanguageName = $secondaryLanguageName;

        return $this;
    }

    public function getTertiaryLanguageId(): ?int
    {
        return $this->tertiaryLanguageId;
    }

    public function setTertiaryLanguageId(?int $tertiaryLanguageId): self
    {
        $this->tertiaryLanguageId = $tertiaryLanguageId;

        return $this;
    }

    public function getTertiaryLanguageName(): ?string
    {
        return $this->tertiaryLanguageName;
    }

    public function setTertiaryLanguageName(?string $tertiaryLanguageName): self
    {
        $this->tertiaryLanguageName = $tertiaryLanguageName;

        return $this;
    }

    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

    public function setEmailAddress(?string $emailAddress): self
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getMobileNumber(): ?string
    {
        return $this->mobileNumber;
    }

    public function setMobileNumber(?string $mobileNumber): self
    {
        $this->mobileNumber = $mobileNumber;

        return $this;
    }
}
