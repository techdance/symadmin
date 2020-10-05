<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_group")
 * @UniqueEntity("name")
 */
class Group extends BaseGroup
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\GroupHasEntity", mappedBy="groups",cascade={"persist","remove"} )
     */
    protected $entities;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="groups")
     */
    private $users;

    public function __construct($roles = array())
    {
        $this->roles = $roles;
        $this->entities = new \Doctrine\Common\Collections\ArrayCollection();
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getEntities()
    {
        return $this->entities;
    }

    public function setEntities($entities)
    {
        return $this->entities = $entities;
    }


    public function addEntity(Entitygroup $entity): self
    {
        if (!$this->entities->contains($entity)) {
            $this->entities[] = $entity;
        }

        return $this;
    }

    public function getUsers()
    {
        return $this->users;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function removeEntity(GroupHasEntity $entity): self
    {
        if ($this->entities->contains($entity)) {
            $this->entities->removeElement($entity);
            // set the owning side to null (unless already changed)
            if ($entity->getGroups() === $this) {
                $entity->setGroups(null);
            }
        }

        return $this;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addGroup($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeGroup($this);
        }

        return $this;
    }

    
}
