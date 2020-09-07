<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SettingsRepository")
 */
class Settings
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $loginLogo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adminDashboardLogo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLoginLogo(): ?string
    {
        return $this->loginLogo;
    }

    public function setLoginLogo(?string $loginLogo): self
    {
        $this->loginLogo = $loginLogo;

        return $this;
    }

    public function getAdminDashboardLogo(): ?string
    {
        return $this->adminDashboardLogo;
    }

    public function setAdminDashboardLogo(?string $adminDashboardLogo): self
    {
        $this->adminDashboardLogo = $adminDashboardLogo;

        return $this;
    }
}
