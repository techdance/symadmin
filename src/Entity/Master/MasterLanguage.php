<?php

namespace App\Entity\Master;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="sym_api_admin_user_master.master_language")
 * @ORM\Entity(repositoryClass="App\Repository\Master\MasterLanguageRepository")
 */
class MasterLanguage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", name="language_code", length=10, nullable=true)
     */
    private $languagecode;

    /**
     * @ORM\Column(type="string", name="language_name", length=150, nullable=true)
     */
    private $languagename;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLanguagecode(): ?string
    {
        return $this->languagecode;
    }

    public function setLanguagecode(?string $languagecode): self
    {
        $this->languagecode = $languagecode;

        return $this;
    }

    public function getLanguagename(): ?string
    {
        return $this->languagename;
    }

    public function setLanguagename(?string $languagename): self
    {
        $this->languagename = $languagename;

        return $this;
    }

}
