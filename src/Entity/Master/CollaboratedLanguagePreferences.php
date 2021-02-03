<?php

namespace App\Entity\Master;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="sym_api_admin_user_master.collaborated_languagepreferences")
 * @ORM\Entity(repositoryClass="App\Repository\Master\CollaboratedLanguagePreferencesRepository")
 */
class CollaboratedLanguagePreferences
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
     * @ORM\Column(type="string", name="languageName", length=75, nullable=true)
     */
    private $languageName;

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

    public function getLanguageName(): ?string
    {
        return $this->languageName;
    }

    public function setLanguageName(?string $languageName): self
    {
        $this->languageName = $languageName;

        return $this;
    }

}
