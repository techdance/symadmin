<?php
namespace App\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;

/**
 * GroupHasEntity
 * @ORM\Table(name="group_entitities")
 * @ORM\Entity
 */
class GroupHasEntity extends BaseGroup
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Group",  inversedBy="groups", fetch="LAZY" )
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id",nullable=false)
     */
    protected $groups;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Entitygroup", inversedBy="groups", fetch="LAZY")
     * @ORM\JoinColumn(name="entitygroup_id", referencedColumnName="id", nullable=false)
     */
    protected $entities;

    

    public function __construct( $roles = array())
    {
        $this->roles = $roles;   
    }

    public function getEntities()
    {
        return $this->entities;
    }

    public function setEntities($entities)
    {
        $this->entities = $entities;
    }

    public function getGroups()
    {
        return $this->groups;
    }

    public function setGroups($groups)
    {
        $this->groups = $groups;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

}