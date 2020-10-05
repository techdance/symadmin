<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="institution_college_schools")
 * @ORM\Entity(repositoryClass="App\Repository\InstitutionCollegeSchoolsRepository")
 */
class InstitutionCollegeSchools
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string",name="college_school_name", length=150, nullable=true)
     */
    private $collegeSchoolName;


    /**
     * @ORM\ManyToOne(targetEntity="InstitutionProfile", inversedBy="collegeSchools", cascade={"persist"})
     * @ORM\JoinColumn(name="ins_profile_id", referencedColumnName="id")
     */
    private $institutionProfile;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCollegeSchoolName(): ?string
    {
        return $this->collegeSchoolName;
    }

    public function setCollegeSchoolName(?string $collegeSchoolName): self
    {
        $this->collegeSchoolName = $collegeSchoolName;

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
