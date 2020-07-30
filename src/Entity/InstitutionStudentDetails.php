<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InstitutionStudentDetailsRepository")
 */
class InstitutionStudentDetails
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $term;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $year;

    /**
     * @ORM\Column(type="string", length=11, nullable=true)
     */
    private $totalStudents;

    /**
     * @ORM\Column(type="string", length=11, nullable=true)
     */
    private $femaleStudents;

    /**
     * @ORM\Column(type="string", length=11, nullable=true)
     */
    private $maleStudents;

    /**
     * @ORM\Column(type="string", length=11, nullable=true)
     */
    private $undergradStudents;

    /**
     * @ORM\Column(type="string", length=11, nullable=true)
     */
    private $gradStudents;

    /**
     * @ORM\Column(type="string", length=11, nullable=true)
     */
    private $otherStudents;

    /**
     * @ORM\Column(type="string", length=11, nullable=true)
     */
    private $fullTimeStudents;

    /**
     * @ORM\Column(type="string", length=11, nullable=true)
     */
    private $inStateStudents;

    /**
     * @ORM\Column(type="string", length=11, nullable=true)
     */
    private $outOfStateStudents;

    /**
     * @ORM\Column(type="string", length=11, nullable=true)
     */
    private $partTimeStudents;

    /**
     * @ORM\Column(type="string", length=11, nullable=true)
     */
    private $interNationalStudents;

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

    public function getTotalStudents(): ?string
    {
        return $this->totalStudents;
    }

    public function setTotalStudents(?string $totalStudents): self
    {
        $this->totalStudents = $totalStudents;

        return $this;
    }

    public function getFemaleStudents(): ?string
    {
        return $this->femaleStudents;
    }

    public function setFemaleStudents(?string $femaleStudents): self
    {
        $this->femaleStudents = $femaleStudents;

        return $this;
    }

    public function getMaleStudents(): ?string
    {
        return $this->maleStudents;
    }

    public function setMaleStudents(?string $maleStudents): self
    {
        $this->maleStudents = $maleStudents;

        return $this;
    }

    public function getUndergradStudents(): ?string
    {
        return $this->undergradStudents;
    }

    public function setUndergradStudents(?string $undergradStudents): self
    {
        $this->undergradStudents = $undergradStudents;

        return $this;
    }

    public function getGradStudents(): ?string
    {
        return $this->gradStudents;
    }

    public function setGradStudents(?string $gradStudents): self
    {
        $this->gradStudents = $gradStudents;

        return $this;
    }

    public function getOtherStudents(): ?string
    {
        return $this->otherStudents;
    }

    public function setOtherStudents(?string $otherStudents): self
    {
        $this->otherStudents = $otherStudents;

        return $this;
    }

    public function getFullTimeStudents(): ?string
    {
        return $this->fullTimeStudents;
    }

    public function setFullTimeStudents(?string $fullTimeStudents): self
    {
        $this->fullTimeStudents = $fullTimeStudents;

        return $this;
    }

    public function getInStateStudents(): ?string
    {
        return $this->inStateStudents;
    }

    public function setInStateStudents(?string $inStateStudents): self
    {
        $this->inStateStudents = $inStateStudents;

        return $this;
    }

    public function getOutOfStateStudents(): ?string
    {
        return $this->outOfStateStudents;
    }

    public function setOutOfStateStudents(?string $outOfStateStudents): self
    {
        $this->outOfStateStudents = $outOfStateStudents;

        return $this;
    }

    public function getPartTimeStudents(): ?string
    {
        return $this->partTimeStudents;
    }

    public function setPartTimeStudents(?string $partTimeStudents): self
    {
        $this->partTimeStudents = $partTimeStudents;

        return $this;
    }

    public function getInterNationalStudents(): ?string
    {
        return $this->interNationalStudents;
    }

    public function setInterNationalStudents(?string $interNationalStudents): self
    {
        $this->interNationalStudents = $interNationalStudents;

        return $this;
    }
}
