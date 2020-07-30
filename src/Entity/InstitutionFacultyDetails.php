<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InstitutionFacultyDetailsRepository")
 */
class InstitutionFacultyDetails
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
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $year;

    /**
     * @ORM\Column(type="string", length=11, nullable=true)
     */
    private $fullTimeFaculty;

    /**
     * @ORM\Column(type="string", length=4, nullable=true)
     */
    private $studentFacultyRatio;

    /**
     * @ORM\Column(type="string", length=11, nullable=true)
     */
    private $facultyHigherDegree;

    /**
     * @ORM\Column(type="string", length=11, nullable=true)
     */
    private $avgUGClassSize;

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

    public function getYear(): ?string
    {
        return $this->year;
    }

    public function setYear(?string $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getFullTimeFaculty(): ?string
    {
        return $this->fullTimeFaculty;
    }

    public function setFullTimeFaculty(?string $fullTimeFaculty): self
    {
        $this->fullTimeFaculty = $fullTimeFaculty;

        return $this;
    }

    public function getStudentFacultyRatio(): ?string
    {
        return $this->studentFacultyRatio;
    }

    public function setStudentFacultyRatio(?string $studentFacultyRatio): self
    {
        $this->studentFacultyRatio = $studentFacultyRatio;

        return $this;
    }

    public function getFacultyHigherDegree(): ?string
    {
        return $this->facultyHigherDegree;
    }

    public function setFacultyHigherDegree(?string $facultyHigherDegree): self
    {
        $this->facultyHigherDegree = $facultyHigherDegree;

        return $this;
    }

    public function getAvgUGClassSize(): ?string
    {
        return $this->avgUGClassSize;
    }

    public function setAvgUGClassSize(?string $avgUGClassSize): self
    {
        $this->avgUGClassSize = $avgUGClassSize;

        return $this;
    }
}
