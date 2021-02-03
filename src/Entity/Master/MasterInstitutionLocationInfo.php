<?php

namespace App\Entity\Master;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="sym_api_admin_user_master.institution_location_info")
 * @ORM\Entity(repositoryClass="App\Repository\Master\MasInstitutionLocationInfoRepository")
 */
class MasterInstitutionLocationInfo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", name="inst_city", length=50, nullable=true)
     */
    private $institutecity;

    /**
     * @ORM\Column(type="string", name="inst_country", length=50, nullable=true)
     */
    private $institutecountry;

    /**
     * @ORM\Column(type="string", name="inst_department", length=150, nullable=true)
     */
    private $institutedepartment;

    /**
     * @ORM\Column(type="string", name="inst_name", length=150, nullable=true)
     */
    private $institutename;

    /**
     * @ORM\Column(type="string", name="inst_code", length=150, nullable=true)
     */
    private $institutecode;

    /**
     * @ORM\Column(type="string", name="inst_state", length=25, nullable=true)
     */
    private $institutestate;

    /**
     * @ORM\Column(type="string", name="inst_timezone", length=150, nullable=true)
     */
    private $institutetimezone;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInstitutecity(): ?string
    {
        return $this->institutecity;
    }

    public function setInstitutecity(?string $institutecity): self
    {
        $this->institutecity = $institutecity;

        return $this;
    }

    public function getInstitutecountry(): ?string
    {
        return $this->institutecountry;
    }

    public function setInstitutecountry(?string $institutecountry): self
    {
        $this->institutecountry = $institutecountry;

        return $this;
    }

    public function getInstitutedepartment(): ?string
    {
        return $this->institutedepartment;
    }

    public function setInstitutedepartment(?string $institutedepartment): self
    {
        $this->institutedepartment = $institutedepartment;

        return $this;
    }

    public function getInstitutename(): ?string
    {
        return $this->institutename;
    }

    public function setInstitutename(?string $institutename): self
    {
        $this->institutename = $institutename;

        return $this;
    }

    public function getInstitutecode(): ?string
    {
        return $this->institutecode;
    }

    public function setInstitutecode(?string $institutecode): self
    {
        $this->institutecode = $institutecode;

        return $this;
    }

    public function getInstitutestate(): ?string
    {
        return $this->institutestate;
    }

    public function setInstitutestate(?string $institutestate): self
    {
        $this->institutestate = $institutestate;

        return $this;
    }

    public function getInstitutetimezone(): ?string
    {
        return $this->institutetimezone;
    }

    public function setInstitutetimezone(?string $institutetimezone): self
    {
        $this->institutetimezone = $institutetimezone;

        return $this;
    }
}
