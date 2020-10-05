<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="settings")
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
     * @ORM\Column(type="string", name="login_logo", length=255, nullable=true)
     */
    private $loginLogo;

    /**
     * @ORM\Column(type="string", name="admin_dashboard_logo", length=255, nullable=true)
     */
    private $adminDashboardLogo;
	
	
	/**
     * @ORM\Column(type="string", name="sso_login", length=255, nullable=true)
     */
    private $ssoLogin;
	
	/**
     * @ORM\Column(type="string",name="collaborated_direct_login", length=255, nullable=true)
     */
    private $collaboratedDirectLogin;
	
	/**
     * @ORM\Column(type="string",name="side_navigation_menu", length=255, nullable=true)
     */
    private $sideNavigationMenu;
	
	/**
     * @ORM\Column(type="string",name="side_navigation_menu_collapsed", length=255, nullable=true)
     */
    private $sideNavigationMenuCollapsed;

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
	
	 public function getSsoLogin(): ?string
    {
        return $this->ssoLogin;
    }

    public function setSsoLogin(?string $ssoLogin): self
    {
        $this->ssoLogin = $ssoLogin;

        return $this;
    }

    public function getCollaboratedDirectLogin(): ?string
    {
        return $this->collaboratedDirectLogin;
    }

    public function setCollaboratedDirectLogin(?string $collaboratedDirectLogin): self
    {
        $this->collaboratedDirectLogin = $collaboratedDirectLogin;

        return $this;
    }

    public function getSideNavigationMenu(): ?string
    {
        return $this->sideNavigationMenu;
    }

    public function setSideNavigationMenu(?string $sideNavigationMenu): self
    {
        $this->sideNavigationMenu = $sideNavigationMenu;

        return $this;
    }

    public function getSideNavigationMenuCollapsed(): ?string
    {
        return $this->sideNavigationMenuCollapsed;
    }

    public function setSideNavigationMenuCollapsed(?string $sideNavigationMenuCollapsed): self
    {
        $this->sideNavigationMenuCollapsed = $sideNavigationMenuCollapsed;

        return $this;
    }
}
