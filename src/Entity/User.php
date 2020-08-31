<?php
// src/Entity/User.php

namespace App\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @UniqueEntity("email", message="Email is already taken.")
 * @UniqueEntity(fields="username", message="Username is already taken.")
 */
class User extends BaseUser
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Group")
     * @ORM\JoinTable(name="fos_user_user_group",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="cascade")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id", onDelete="cascade")}
     * )
     */
    protected $groups;


    public function __construct()
    {
        parent::__construct();

        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $middleName;

    /**
     * {@inheritdoc}
     * @Assert\Regex(pattern="/^[a-zA-Z0-9_]*$/", match=true, message="Username only allowed numbers, alphabets or underscore")
     */
    protected $username;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $prefix;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $institutionName;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     * @Assert\NotBlank
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $ssn;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $vetran;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $ethinicity;

    
    /**
     * @ORM\Column(type="date", nullable=true)
     * @Assert\NotBlank
     */
    private $dateOfBirth;
    

    /**
     *
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Assert\NotBlank
     */
    private $gender;

   
    /**
     *
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    private $emergencyContactPerson;

     /**
     *
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $emergencyContactPhone;


    /**
     *
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $address1;

    /**
     *
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $address2;

    /**
     *
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    private $city;

    /**
     *
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    private $state;

    /**
     *
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    private $zip;

    /**
     *
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $position;

    /**
     *
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $dummyPassword;

    

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

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

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function setMiddleName(string $middleName): self
    {
        $this->middleName = $middleName;

        return $this;
    }

    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    public function setEmail($email)
    {
        $email = is_null($email) ? '' : $email;
        parent::setEmail($email);
        //$this->setUsername($email);
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


    public function setPhone($phone) 
    {
        $this->phone = $phone;
    }
    
    public function getPhone() 
    {
        return $this->phone;
    }


    public function setSsn($ssn) 
    {
        $this->ssn = $ssn;
    }
    
    public function getSsn() 
    {
        return $this->ssn;
    }

    public function setVetran($vetran) 
    {
        $this->vetran = $vetran;
    }
    
    public function getVetran() 
    {
        return $this->vetran;
    }

    public function setEthinicity($ethinicity) 
    {
        $this->ethinicity = $ethinicity;
    }
    
    public function getEthinicity() 
    {
        return $this->ethinicity;
    }

    public function setDateOfBirth($dateOfBirth) 
    {
        $this->dateOfBirth = $dateOfBirth;
    }
    
    public function getDateOfBirth() 
    {
        return $this->dateOfBirth;
    }


    public function setGender($gender) 
    {
        $this->gender = $gender;
    }
    
    public function getGender() 
    {
        return $this->gender;
    }

    public function setEmergencyContactPhone($emergencyContactPhone) 
    {
        $this->emergencyContactPhone = $emergencyContactPhone;
    }
    
    public function getEmergencyContactPhone() 
    {
        return $this->emergencyContactPhone;
    }

    public function setEmergencyContactPerson($emergencyContactPerson) 
    {
        $this->emergencyContactPerson = $emergencyContactPerson;
    }
    
    public function getEmergencyContactPerson() 
    {
        return $this->emergencyContactPerson;
    }


    public function setAddress1($address1) 
    {
        $this->address1 = $address1;
    }
    
    public function getAddress1() 
    {
        return $this->address1;
    }

    public function setAddress2($address2) 
    {
        $this->address2 = $address2;
    }
    
    public function getAddress2() 
    {
        return $this->address2;
    }

    public function setCity($city) 
    {
        $this->city = $city;
    }
    
    public function getCity() 
    {
        return $this->city;
    }

    public function setState($state) 
    {
        $this->state = $state;
    }
    
    public function getState() 
    {
        return $this->state;
    }

    public function setZip($zip) 
    {
        $this->zip = $zip;
    }
    
    public function getZip() 
    {
        return $this->zip;
    }

    public function setPosition($position) 
    {
        $this->position = $position;
    }
    
    public function getPosition() 
    {
        return $this->position;
    }

    

    public function setDummyPassword($dummyPassword) 
    {
        $this->dummyPassword = $dummyPassword;
    }
    
    public function getDummyPassword() 
    {
        return $this->dummyPassword;
    }

    public function getRoles()
    {
     
        $roles = $this->roles;

        foreach ($this->getGroups() as $group) {
          
            $roles = array_merge($roles, [$group->getName()]);
        }

        // we need to make sure to have at least one role
        if (!in_array(static::ROLE_DEFAULT, $roles)) {
            $roles[] = static::ROLE_DEFAULT;
        }
    
        return array_unique($roles);
    }

    public function getActiveRoles() 
    {
        $roles = $this->roles;

        foreach ($this->getGroups() as $group) {
        
            $roles = array_merge($roles, [$group->getName()]);
        }

        return $roles;
    }


    public function getFullName() 
    {
        return $this->firstName. ' ' .$this->lastName;
    }

    public function getFullNameWithPrefix()
    {
        return $this->prefix. '. ' .$this->firstName. ' ' .$this->lastName;
    }


}
