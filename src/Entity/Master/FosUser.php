<?php

namespace App\Entity\Master;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * FosUser
 *
 * @ORM\Table(name="sym_api_admin_user_master.fos_user")
 * @ORM\Entity
 */
class FosUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=180, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="username_canonical", type="string", length=180, nullable=false)
     */
    private $usernameCanonical;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=180, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="email_canonical", type="string", length=180, nullable=false)
     */
    private $emailCanonical;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     */
    private $enabled;

    /**
     * @var string|null
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=true)
     */
    private $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    private $lastLogin;

    /**
     * @var string|null
     *
     * @ORM\Column(name="confirmation_token", type="string", length=180, nullable=true)
     */
    private $confirmationToken;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="password_requested_at", type="datetime", nullable=true)
     */
    private $passwordRequestedAt;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="array", length=0, nullable=false)
     */
    private $roles;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=100, nullable=false)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=100, nullable=false)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="prefix", type="string", length=20, nullable=false)
     */
    private $prefix;

    /**
     * @var string
     *
     * @ORM\Column(name="suffix", type="string", length=20, nullable=true)
     */
    private $suffix;

    /**
     * @var string
     *
     * @ORM\Column(name="institution_name", type="string", length=150, nullable=false)
     */
    private $institutionName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="phone", type="string", length=25, nullable=true)
     */
    private $phone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ssn", type="string", length=150, nullable=true)
     */
    private $ssn;

    /**
     * @var string|null
     *
     * @ORM\Column(name="vetran", type="string", length=150, nullable=true)
     */
    private $vetran;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ethinicity", type="string", length=150, nullable=true)
     */
    private $ethinicity;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_of_birth", type="date", nullable=true)
     */
    private $dateOfBirth;

    /**
     * @var string|null
     *
     * @ORM\Column(name="gender", type="string", length=10, nullable=true)
     */
    private $gender;

    /**
     * @var string|null
     *
     * @ORM\Column(name="emergency_contact_person", type="string", length=75, nullable=true)
     */
    private $emergencyContactPerson;

    /**
     * @var string|null
     *
     * @ORM\Column(name="emergency_contact_phone", type="string", length=25, nullable=true)
     */
    private $emergencyContactPhone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="address1", type="string", length=150, nullable=true)
     */
    private $address1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="address2", type="string", length=150, nullable=true)
     */
    private $address2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="city", type="string", length=75, nullable=true)
     */
    private $city;

    /**
     * @var string|null
     *
     * @ORM\Column(name="state", type="string", length=75, nullable=true)
     */
    private $state;

    /**
     * @var string|null
     *
     * @ORM\Column(name="zip", type="string", length=75, nullable=true)
     */
    private $zip;

    /**
     * @var string|null
     *
     * @ORM\Column(name="middle_name", type="string", length=100, nullable=true)
     */
    private $middleName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="position", type="string", length=150, nullable=true)
     */
    private $position;

    /**
     * @var string|null
     *
     * @ORM\Column(name="dummy_password", type="string", length=150, nullable=true)
     */
    private $dummyPassword;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="FosGroup", inversedBy="user")
     * @ORM\JoinTable(name="sym_api_admin_user_master.fos_user_user_group",
     *   joinColumns={
     *     @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     *   }
     * )
     */
    private $group;

    /**
     * @ORM\Column(type="string",name="institution_profile_code", length=150, nullable=true)
     */
    private $institutionCode;

    /**
     * @ORM\Column(type="integer",name="local_fos_id", length=150, nullable=true)
     */
    private $localFosId;

    /**
     * @ORM\Column(type="string",name="department" , length=150, nullable=true)
     */
    private $department;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $thoughts;

    /**
     * @var bool
     *
     * @ORM\Column(name="onlineStatus", type="boolean", nullable=true)
     */
    private $onlineStatus;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->group = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getUsernameCanonical(): ?string
    {
        return $this->usernameCanonical;
    }

    public function setUsernameCanonical(string $usernameCanonical): self
    {
        $this->usernameCanonical = $usernameCanonical;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getEmailCanonical(): ?string
    {
        return $this->emailCanonical;
    }

    public function setEmailCanonical(string $emailCanonical): self
    {
        $this->emailCanonical = $emailCanonical;

        return $this;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getSalt(): ?string
    {
        return $this->salt;
    }

    public function setSalt(?string $salt): self
    {
        $this->salt = $salt;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?\DateTimeInterface $lastLogin): self
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    public function getConfirmationToken(): ?string
    {
        return $this->confirmationToken;
    }

    public function setConfirmationToken(?string $confirmationToken): self
    {
        $this->confirmationToken = $confirmationToken;

        return $this;
    }

    public function getPasswordRequestedAt(): ?\DateTimeInterface
    {
        return $this->passwordRequestedAt;
    }

    public function setPasswordRequestedAt(?\DateTimeInterface $passwordRequestedAt): self
    {
        $this->passwordRequestedAt = $passwordRequestedAt;

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPrefix(): ?string
    {
        return $this->prefix;
    }

    public function setPrefix(string $prefix): self
    {
        $this->prefix = $prefix;

        return $this;
    }

    public function getInstitutionName(): ?string
    {
        return $this->institutionName;
    }

    public function setInstitutionName(string $institutionName): self
    {
        $this->institutionName = $institutionName;

        return $this;
    }

    public function getDepartment(): ?string
    {
        return $this->department;
    }

    public function setDepartment(string $department): self
    {
        $this->department = $department;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getSsn(): ?string
    {
        return $this->ssn;
    }

    public function setSsn(?string $ssn): self
    {
        $this->ssn = $ssn;

        return $this;
    }

    public function getVetran(): ?string
    {
        return $this->vetran;
    }

    public function setVetran(?string $vetran): self
    {
        $this->vetran = $vetran;

        return $this;
    }

    public function getEthinicity(): ?string
    {
        return $this->ethinicity;
    }

    public function setEthinicity(?string $ethinicity): self
    {
        $this->ethinicity = $ethinicity;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?\DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getEmergencyContactPerson(): ?string
    {
        return $this->emergencyContactPerson;
    }

    public function setEmergencyContactPerson(?string $emergencyContactPerson): self
    {
        $this->emergencyContactPerson = $emergencyContactPerson;

        return $this;
    }

    public function getEmergencyContactPhone(): ?string
    {
        return $this->emergencyContactPhone;
    }

    public function setEmergencyContactPhone(?string $emergencyContactPhone): self
    {
        $this->emergencyContactPhone = $emergencyContactPhone;

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

    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(?string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    public function setMiddleName(?string $middleName): self
    {
        $this->middleName = $middleName;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(?string $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getDummyPassword(): ?string
    {
        return $this->dummyPassword;
    }

    public function setDummyPassword(?string $dummyPassword): self
    {
        $this->dummyPassword = $dummyPassword;

        return $this;
    }

    /**
     * @return Collection|FosGroup[]
     */
    public function getGroup(): Collection
    {
        return $this->group;
    }

    public function addGroup(FosGroup $group): self
    {
        if (!$this->group->contains($group)) {
            $this->group[] = $group;
        }

        return $this;
    }

    public function removeGroup(FosGroup $group): self
    {
        if ($this->group->contains($group)) {
            $this->group->removeElement($group);
        }

        return $this;
    }

    public function getInstitutionCode(): ?string
    {
        return $this->institutionCode;
    }

    public function setInstitutionCode(?string $institutionCode): self
    {
        $this->institutionCode = $institutionCode;

        return $this;
    }

    public function getLocalFosId(): ?int
    {
        return $this->localFosId;
    }

    public function setLocalFosId(?int $localFosId): self
    {
        $this->localFosId = $localFosId;

        return $this;
    }

    public function getThoughts(): ?string
    {
        return $this->thoughts;
    }

    public function setThoughts(?string $thoughts): self
    {
        $this->thoughts = $thoughts;

        return $this;
    }

    public function getOnlineStatus(): ?bool
    {
        return $this->onlineStatus;
    }

    public function setOnlineStatus(bool $onlineStatus): self
    {
        $this->onlineStatus = $onlineStatus;

        return $this;
    }

    public function getSuffix(): ?string
    {
        return $this->suffix;
    }

    public function setSuffix(?string $suffix): self
    {
        $this->suffix = $suffix;

        return $this;
    }

   

}
