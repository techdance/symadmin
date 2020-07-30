<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InstitutionAccrediationRepository")
 */
class InstitutionAccrediation
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
    private $accrediation;

    /**
     * @ORM\ManyToOne(targetEntity="InstitutionProfile", inversedBy="accrediations", cascade={"persist"})
     * @ORM\JoinColumn(name="ins_profile_id", referencedColumnName="id")
     */
    private $institutionProfile;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccrediation(): ?string
    {
        return $this->accrediation;
    }

    public function setAccrediation(?string $accrediation): self
    {
        $this->accrediation = $accrediation;

        return $this;
    }

    public function getInstitutionProfile()
    {
        return $this->institutionProfile;
    }


    public function setInstitutionProfile($institutionProfile)
    {
        $this->institutionProfile = $institutionProfile;
    }
}
