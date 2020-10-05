<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="institution_academic_details")
 * @ORM\Entity(repositoryClass="App\Repository\InstitutionAcademicDetailsRepository")
 */
class InstitutionAcademicDetails
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
    private $term;

    /**
     * @ORM\Column(type="string",name="academic_year", length=11, nullable=true)
     */
    private $academicYear;

    /**
     * @ORM\Column(type="string",name="associate_degrees", length=11, nullable=true)
     */
    private $associateDegrees;

    /**
     * @ORM\Column(type="string",name="bachelors_degrees", length=11, nullable=true)
     */
    private $bachelorsDegrees;

    /**
     * @ORM\Column(type="string",name="master_degrees", length=11, nullable=true)
     */
    private $masterDegrees;

    /**
     * @ORM\Column(type="string",name="doctorate_degrees", length=11, nullable=true)
     */
    private $doctorateDegrees;

    /**
     * @ORM\Column(type="string",name="under_graduate", length=11, nullable=true)
     */
    private $underGraduate;

    /**
     * @ORM\Column(type="string", length=11, nullable=true)
     */
    private $graduate;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $year;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTerm(): ?string
    {
        return $this->term;
    }

    public function setTerm(?string $term): self
    {
        $this->term = $term;

        return $this;
    }

    public function getAcademicYear(): ?string
    {
        return $this->academicYear;
    }

    public function setAcademicYear(?string $academicYear): self
    {
        $this->academicYear = $academicYear;

        return $this;
    }

    public function getAssociateDegrees(): ?string
    {
        return $this->associateDegrees;
    }

    public function setAssociateDegrees(?string $associateDegrees): self
    {
        $this->associateDegrees = $associateDegrees;

        return $this;
    }

    public function getBachelorsDegrees(): ?string
    {
        return $this->bachelorsDegrees;
    }

    public function setBachelorsDegrees(?string $bachelorsDegrees): self
    {
        $this->bachelorsDegrees = $bachelorsDegrees;

        return $this;
    }

    public function getMasterDegrees(): ?string
    {
        return $this->masterDegrees;
    }

    public function setMasterDegrees(?string $masterDegrees): self
    {
        $this->masterDegrees = $masterDegrees;

        return $this;
    }

    public function getDoctorateDegrees(): ?string
    {
        return $this->doctorateDegrees;
    }

    public function setDoctorateDegrees(?string $doctorateDegrees): self
    {
        $this->doctorateDegrees = $doctorateDegrees;

        return $this;
    }

    public function getUnderGraduate(): ?string
    {
        return $this->underGraduate;
    }

    public function setUnderGraduate(?string $underGraduate): self
    {
        $this->underGraduate = $underGraduate;

        return $this;
    }

    public function getGraduate(): ?string
    {
        return $this->graduate;
    }

    public function setGraduate(?string $graduate): self
    {
        $this->graduate = $graduate;

        return $this;
    }

    public function getYear(): ?string
    {
        return $this->year;
    }

    public function setYear(?string $year): self
    {
        $this->year = $year;

        return $this;
    }
}
