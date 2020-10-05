<?php

namespace App\Entity\Master;

use Doctrine\ORM\Mapping as ORM;

/**
 * GroupEntitities
 *
 * @ORM\Table(name="sym_api_admin_user_master.group_entitities", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_D75028715E237E06", columns={"name"})}, indexes={@ORM\Index(name="IDX_D750287119D10A19", columns={"entitygroup_id"}), @ORM\Index(name="IDX_D7502871FE54D947", columns={"group_id"})})
 * @ORM\Entity
 */
class GroupEntitities
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
     * @ORM\Column(name="name", type="string", length=180, nullable=false)
     */
    private $name;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="array", length=0, nullable=false)
     */
    private $roles;

    /**
     * @var \FosEntityGroup
     *
     * @ORM\ManyToOne(targetEntity="FosEntityGroup")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="entitygroup_id", referencedColumnName="id")
     * })
     */
    private $entitygroup;

    /**
     * @var \FosGroup
     *
     * @ORM\ManyToOne(targetEntity="FosGroup")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     * })
     */
    private $group;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getEntitygroup(): ?FosEntityGroup
    {
        return $this->entitygroup;
    }

    public function setEntitygroup(?FosEntityGroup $entitygroup): self
    {
        $this->entitygroup = $entitygroup;

        return $this;
    }

    public function getGroup(): ?FosGroup
    {
        return $this->group;
    }

    public function setGroup(?FosGroup $group): self
    {
        $this->group = $group;

        return $this;
    }


}
