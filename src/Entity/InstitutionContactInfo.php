<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="institution_contact_info")
 * @ORM\Entity(repositoryClass="App\Repository\InstitutionContactInfoRepository")
 */
class InstitutionContactInfo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string",name="office_number", length=50, nullable=true)
     */
    private $officeNumber;

    /**
     * @ORM\Column(type="string",name="mailing_name", length=75, nullable=true)
     */
    private $mailingName;

    /**
     * @ORM\Column(type="string",name="fax_number", length=75, nullable=true)
     */
    private $faxNumber;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $department;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $website;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $address1;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $address2;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $state;

    /**
     * @ORM\Column(type="string",name="postal_code", length=25, nullable=true)
     */
    private $postalCode;

    /**
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    private $new;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOfficeNumber(): ?string
    {
        return $this->officeNumber;
    }

    public function setOfficeNumber(?string $officeNumber): self
    {
        $this->officeNumber = $officeNumber;

        return $this;
    }

    public function getMailingName(): ?string
    {
        return $this->mailingName;
    }

    public function setMailingName(?string $mailingName): self
    {
        $this->mailingName = $mailingName;

        return $this;
    }

    public function getFaxNumber(): ?string
    {
        return $this->faxNumber;
    }

    public function setFaxNumber(?string $faxNumber): self
    {
        $this->faxNumber = $faxNumber;

        return $this;
    }

    public function getDepartment(): ?string
    {
        return $this->department;
    }

    public function setDepartment(?string $department): self
    {
        $this->department = $department;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAddress1(): ?string
    {
        return $this->address1;
    }

    public function setAddress1(?string $address1): self
    {
        $this->address1 = $address1;

        return $this;
    }

    public function getAddress2(): ?string
    {
        return $this->address2;
    }

    public function setAddress2(?string $address2): self
    {
        $this->address2 = $address2;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getNew(): ?string
    {
        return $this->new;
    }

    public function setNew(?string $new): self
    {
        $this->new = $new;

        return $this;
    }
}
