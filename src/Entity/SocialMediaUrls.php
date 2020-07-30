<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SocialMediaUrlsRepository")
 */
class SocialMediaUrls
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $socialMedia;

    /**
     * @ORM\Column(type="text")
     */
    private $url;


    /**
     * @ORM\ManyToOne(targetEntity="InstitutionProfile", inversedBy="socialMedias", cascade={"persist"})
     * @ORM\JoinColumn(name="ins_profile_id", referencedColumnName="id")
     */
    private $institutionProfile;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSocialMedia(): ?string
    {
        return $this->socialMedia;
    }

    public function setSocialMedia(string $socialMedia): self
    {
        $this->socialMedia = $socialMedia;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

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
