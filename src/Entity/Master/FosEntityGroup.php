<?php

namespace App\Entity\Master;

use Doctrine\ORM\Mapping as ORM;

/**
 * FosEntityGroup
 *
 * @ORM\Table(name="sym_api_admin_user_master.fos_entity_group")
 * @ORM\Entity
 */
class FosEntityGroup
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
     * @ORM\Column(name="name", type="string", length=75, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=75, nullable=false)
     */
    private $label;

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

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }


}
