<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="institution_degrees")
 * @ORM\Entity(repositoryClass="App\Repository\InstitutionDegreesRepository")
 */
class InstitutionDegrees
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string",name="degree_name", length=255, nullable=true)
     */
    private $degreeName;

    /**
     * @ORM\ManyToOne(targetEntity="InstitutionProfile", inversedBy="degrees", cascade={"persist"})
     * @ORM\JoinColumn(name="ins_profile_id", referencedColumnName="id")
     */
    private $institutionProfile;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDegreeName(): ?string
    {
        return $this->degreeName;
    }

    public function setDegreeName(?string $degreeName): self
    {
        $this->degreeName = $degreeName;

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
