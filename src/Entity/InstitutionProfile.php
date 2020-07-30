<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InstitutionProfileRepository")
 */
class InstitutionProfile
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $institutionName;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $campusName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $insProfileImage;

    /**
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    private $founded;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $insType;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $language;

    /**
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    private $president;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $academicCalendar;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $otherLanguages;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $totalEmployees;

    /**
     * @ORM\Column(type="string", length=11, nullable=true)
     */
    private $alumini;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $overview;


    /**
     * One institution has one contact info.
     * @ORM\OneToOne(targetEntity="InstitutionContactInfo", mappedBy="institution_profile", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="institution_contact_id", referencedColumnName="id")
     */
    private $institutionContact;

    /**
     * @ORM\OneToOne(targetEntity="InstitutionLocationInfo", mappedBy="institution_profile", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="institution_location_id", referencedColumnName="id")
     */
    private $institutionLocation;

    /**
     * @ORM\OneToOne(targetEntity="InstitutionStudentDetails", mappedBy="institution_profile", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="student_det_id", referencedColumnName="id")
     */
    private $studentDetails;

    /**
     * @ORM\OneToOne(targetEntity="InstitutionFacultyDetails", mappedBy="institution_profile", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="faculty_det_id", referencedColumnName="id")
     */
    private $facultyDetails;


    /**
     * @ORM\OneToOne(targetEntity="InstitutionAcademicDetails", mappedBy="institution_profile", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="academic_det_id", referencedColumnName="id")
     */
    private $academicDetails;


     /**
     * @ORM\OneToMany(targetEntity="InstitutionCollegeSchools", mappedBy="institutionProfile", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $collegeSchools;

     /**
     * @ORM\OneToMany(targetEntity="InstitutionAccrediation", mappedBy="institutionProfile", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $accrediations;

     /**
     * @ORM\OneToMany(targetEntity="InstitutionRecognition", mappedBy="institutionProfile", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $recognitions;

     /**
     * @ORM\OneToMany(targetEntity="InstitutionDegrees", mappedBy="institutionProfile", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $degrees;

     /**
     * @ORM\OneToMany(targetEntity="SocialMediaUrls", mappedBy="institutionProfile", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $socialMedias;


    public function __construct()
    {
        $this->collegeSchools = new \Doctrine\Common\Collections\ArrayCollection();
        $this->accrediations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->recognitions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->degrees = new \Doctrine\Common\Collections\ArrayCollection();
        $this->socialMedias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInsProfileImage()
    {
        return $this->insProfileImage;
    }

   
    public function setInsProfileImage($insProfileImage)
    {
        $this->insProfileImage = $insProfileImage;

        return $this;
    }

    public function getFounded(): ?string
    {
        return $this->founded;
    }

    public function setFounded(?string $founded): self
    {
        $this->founded = $founded;

        return $this;
    }

    public function getInsType(): ?string
    {
        return $this->insType;
    }

    public function setInsType(?string $insType): self
    {
        $this->insType = $insType;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(?string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getPresident(): ?string
    {
        return $this->president;
    }

    public function setPresident(?string $president): self
    {
        $this->president = $president;

        return $this;
    }

    public function getAcademicCalendar(): ?string
    {
        return $this->academicCalendar;
    }

    public function setAcademicCalendar(?string $academicCalendar): self
    {
        $this->academicCalendar = $academicCalendar;

        return $this;
    }

    public function getOtherLanguages(): ?string
    {
        return $this->otherLanguages;
    }

    public function setOtherLanguages(?string $otherLanguages): self
    {
        $this->otherLanguages = $otherLanguages;

        return $this;
    }

    public function getTotalEmployees(): ?int
    {
        return $this->totalEmployees;
    }

    public function setTotalEmployees(?int $totalEmployees): self
    {
        $this->totalEmployees = $totalEmployees;

        return $this;
    }

    public function getAlumini(): ?string
    {
        return $this->alumini;
    }

    public function setAlumini(?string $alumini): self
    {
        $this->alumini = $alumini;

        return $this;
    }

    public function getOverview(): ?string
    {
        return $this->overview;
    }

    public function setOverview(?string $overview): self
    {
        $this->overview = $overview;

        return $this;
    }

    public function getInstitutionName(): ?string
    {
        return $this->institutionName;
    }

    public function setInstitutionName(?string $institutionName): self
    {
        $this->institutionName = $institutionName;

        return $this;
    }

    public function getCampusName(): ?string
    {
        return $this->campusName;
    }

    public function setCampusName(?string $campusName): self
    {
        $this->campusName = $campusName;

        return $this;
    }

    public function setInstitutionContact($institutionContact): self
    {
        $this->institutionContact = $institutionContact;

        return $this;
    }

    public function getInstitutionContact()
    {
        return $this->institutionContact;
    }


    public function setInstitutionLocation($insLocation): self
    {
        $this->institutionLocation = $insLocation;

        return $this;
    }

    public function getInstitutionLocation()
    {
        return $this->institutionLocation;
    }


    public function setStudentDetails($studentDetails): self
    {
        $this->studentDetails = $studentDetails;

        return $this;
    }

    public function getStudentDetails()
    {
        return $this->studentDetails;
    }


    public function setFacultyDetails($facultyDetails): self
    {
        $this->facultyDetails = $facultyDetails;

        return $this;
    }

    public function getFacultyDetails()
    {
        return $this->facultyDetails;
    }

    public function setAcademicDetails($academicDetails): self
    {
        $this->academicDetails = $academicDetails;

        return $this;
    }

    public function getAcademicDetails()
    {
        return $this->academicDetails;
    }

    public function getCollegeSchools()
    {
        return $this->collegeSchools;
    }

    public function addCollegeSchool(InstitutionCollegeSchools $school)
    {
        $school->setInstitutionProfile($this);

        $this->collegeSchools->add($school);
    }

    public function removeCollegeSchool(InstitutionCollegeSchools $school)
    {
        $this->collegeSchools->removeElement($school);
    }

    public function getAccrediations()
    {
        return $this->accrediations;
    }

    public function addAccrediation(InstitutionAccrediation $accrediation)
    {
        $accrediation->setInstitutionProfile($this);

        $this->accrediations->add($accrediation);
    }

    public function removeAccrediation(InstitutionAccrediation $accrediation)
    {
        $this->accrediations->removeElement($accrediation);
    }

    public function getRecognitions()
    {
        return $this->recognitions;
    }

    public function addRecognition(InstitutionRecognition $recognition)
    {
        $recognition->setInstitutionProfile($this);

        $this->recognitions->add($recognition);
    }

    public function removeRecognition(InstitutionRecognition $recognition)
    {
        $this->recognitions->removeElement($recognition);
    }

    public function getDegrees()
    {
        return $this->degrees;
    }

    public function addDegree(InstitutionDegrees $degree)
    {
        $degree->setInstitutionProfile($this);

        $this->degrees->add($degree);
    }

    public function removeDegree(InstitutionDegrees $degree)
    {
        $this->degrees->removeElement($degree);
    }


    public function getSocialMedias()
    {
        return $this->socialMedias;
    }

    public function addSocialMedia(SocialMediaUrls $socialMedia)
    {
        $socialMedia->setInstitutionProfile($this);

        $this->socialMedias->add($socialMedia);
    }

    public function removeSocialMedia(SocialMediaUrls $socialMedia)
    {
        $this->socialMedias->removeElement($socialMedia);
    }
}
