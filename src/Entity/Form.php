<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Form
 *
 * @ORM\Table(name="form")
 * @ORM\Entity(repositoryClass="App\Repository\FormRepository")
 */
class Form
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true, unique=false)
     */
    private $name;

    /**
     * @var array
     *
     * @ORM\Column(name="json", type="json_array")
     */
    private $json;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="FormValue", mappedBy="form", cascade={"persist", "remove"})
     */
    private $values;

    /**
     * @ORM\Column(type="string",name="form_image")
     */
    private $formImage;


    /**
     * Form constructor.
     */
    public function __construct() {
        $this->values = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Set json
     *
     * @param array $json
     *
     * @return Form
     */
    public function setJson($json)
    {
        $this->json = $json;

        return $this;
    }

    /**
     * Get json
     *
     * @return array
     */
    public function getJson()
    {
        return $this->json;
    }

    /**
     * @return ArrayCollection
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @param ArrayCollection $values
     */
    public function setValues($values)
    {
        $this->values = $values;
    }

    /**
     *
     * @return void
     */
    public function getFormImage()
    {
        return $this->formImage;
    }

    /**
     * @param string $formImage
     */
    public function setFormImage($formImage)
    {
        $this->formImage = $formImage;

        return $this;
    }

    public function addValue(FormValue $value): self
    {
        if (!$this->values->contains($value)) {
            $this->values[] = $value;
            $value->setForm($this);
        }

        return $this;
    }

    public function removeValue(FormValue $value): self
    {
        if ($this->values->contains($value)) {
            $this->values->removeElement($value);
            // set the owning side to null (unless already changed)
            if ($value->getForm() === $this) {
                $value->setForm(null);
            }
        }

        return $this;
    }
}

