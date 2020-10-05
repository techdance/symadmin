<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="institution_recognition")
 * @ORM\Entity(repositoryClass="App\Repository\InstitutionRecognitionRepository")
 */
class InstitutionRecognition
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
    private $recognition;

    /**
     * @ORM\ManyToOne(targetEntity="InstitutionProfile", inversedBy="recognitions", cascade={"persist"})
     * @ORM\JoinColumn(name="ins_profile_id", referencedColumnName="id")
     */
    private $institutionProfile;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRecognition(): ?string
    {
        return $this->recognition;
    }

    public function setRecognition(?string $recognition): self
    {
        $this->recognition = $recognition;

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
