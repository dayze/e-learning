<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Table(name="`user`")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"supervisor" = "Supervisor", "student" = "Student", "user" = "User"})
 * @UniqueEntity(fields="username", message="Ce pseudo est déjà prit.")
 * @UniqueEntity(fields="email", message="Cette email est déjà prit.")
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
     * @Assert\NotBlank()
     */
    protected $username;

    /**
     * @Assert\Email(
     *      message = "L'email {{ value }} n'est pas valide",
     *      checkMX = true
     *     )
     * @Assert\NotBlank()
     */
    protected $email;

    protected $password;

    protected $plainPassword;

    public function __construct()
    {
        $this->sections = new ArrayCollection();
        parent::__construct();
        // your own logic
    }


    /**
     * @ORM\ManyToMany(targetEntity="Section", mappedBy="users")
     */
    private $sections;

    public function addSection(Section $section)
    {
        $this->sections[] = $section;
        $section->addUser($this);
        return $this;
    }

    public function setSection($sections)
    {
        $this->sections = $sections;
    }

    /**
     * @param Section $section
     */
    public function removeSection(Section $section)
    {
        $this->sections->removeElement($section);
        $section->removeDocument($this);
    }

    /**
     * @return mixed
     */
    public function getSections()
    {
        return $this->sections;
    }

    /**
     * @param mixed $sections
     */
    public function setSections($sections)
    {
        $this->sections = $sections;
    }
}