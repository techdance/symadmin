<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_entity_group")
 * @UniqueEntity("name")
 */
class Entitygroup
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=75)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=75)
     */
    protected $label;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\GroupHasEntity", mappedBy="entities",cascade={"persist","remove"}, orphanRemoval=TRUE )
     */
    protected $groups;


    public function __construct()
    {
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getGroups()
    {
        return $this->groups;
    }
    
    public function setGroups($groups)
    {
        return $this->groups = $groups;
    }

    public function addGroup(Group $group): self
    {
        if (!$this->groups->contains($group)) {
            $this->groups[] = $group;
            $group->setEntities($this);
        }

        return $this;
    }
}
