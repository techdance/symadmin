<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 * @ORM\Table(name="registration")
 */
class Registration {
  /**
   * @ORM\Column(type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;
  /**
   * @ORM\Column(type="string", length=100)
   * @Assert\NotBlank()
   *
   */
  private $firstname;
  /**
   * @ORM\Column(type="string")
   * @Assert\NotBlank()
   */
  private $lastname;
  /**
   * @ORM\Column(type="string")
   * @Assert\NotBlank()
   */
  private $prefix;
  /**
   * @ORM\Column(type="string")
   * @Assert\NotBlank()
   */
  private $institutionemail;
  /**
   * @ORM\Column(type="string")
   * @Assert\NotBlank()
   */
  private $institutionname;
  /**
   * @ORM\Column(type="string")
   * @Assert\NotBlank()
   */
  private $password;
  /**
   * @return mixed
   */
  public function getId()
  {
    return $this->id;
  }
  /**
   * @param mixed $id
   */
  public function setId($id)
  {
    $this->id = $id;
  }
  /**
   * @return mixed
   */
  public function getFirstname()
  {
    return $this->firstname;
  }
  /**
   * @param mixed $name
   */
  public function setFirstname($firstname)
  {
    $this->firstname = $firstname;
  }
  /**
   * @return mixed
   */
  public function getLastname()
  {
    return $this->lastname;
  }
  /**
   * @param mixed $lastname
   */
  public function setLastname($lastname)
  {
    $this->lastname = $lastname;
  }
  /**
   * @return mixed
   */
  public function getPrefix()
  {
    return $this->prefix;
  }
  /**
   * @param mixed $prefix
   */
  public function setPrefix($prefix)
  {
    $this->prefix = $prefix;
  }
  /**
   * @return mixed
   */
  public function getInstitutionemail()
  {
    return $this->institutionemail;
  }
  /**
   * @param mixed $institutionemail
   */
  public function setInstitutionemail($institutionemail)
  {
    $this->institutionemail = $institutionemail;
  }
  /**
   * @return mixed
   */
  public function getInstitutionname()
  {
    return $this->institutionname;
  }
  /**
   * @param mixed $institutionname
   */
  public function setInstitutionname($institutionname)
  {
    $this->institutionname = $institutionname;
  }
  /**
   * @return mixed
   */
  public function getPassword()
  {
    return $this->password;
  }
  /**
   * @param mixed $password
   */
  public function setPassword($password)
  {
    $this->password = $password;
  }

}