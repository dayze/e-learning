<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Section
 *
 * @ORM\Table(name="section")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SectionRepository")
 */
class Section
{

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->documents = new ArrayCollection();
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string*
     * @ORM\Column(name="name", type="string", length=100)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="promotion", type="date")
     */
    private $promotion;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="sections")
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity="Document", inversedBy="sections", cascade={"persist"})
     * @ORM\JoinTable(name="section_document")
     */

    private $documents;

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
     * Set name
     *
     * @param string $name
     *
     * @return Section
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set promotion
     *
     * @param \DateTime $promotion
     *
     * @return Section
     */
    public function setPromotion($promotion)
    {
        $this->promotion = $promotion;

        return $this;
    }

    /**
     * Get promotion
     *
     * @return \DateTime
     */
    public function getPromotion()
    {
        return $this->promotion;
    }

    /**
     * @return mixed
     * @internal param User $user
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param User $user
     * @internal param mixed $users
     * @return $this
     */
    public function addUser(User $user)
    {
        $this->users->add($user);
        return $this;
    }

    /**
     * @param User $user
     */
    public function removeUser(User $user)
    {
        $this->users->removeElement($user);
    }

    public function setUsers($users)
    {
        $this->users = $users;
    }

    /**
     * @return ArrayCollection
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * @param Document $document
     * @return $this
     * @internal param User $user
     * @internal param mixed $users
     */
    public function addDocument(Document $document)
    {
        $this->documents->add($document);
        return $this;
    }

    /**
     * @param Document $document
     * @internal param User $user
     */
    public function removeDocument(Document $document)
    {
        $this->documents->removeElement($document);
    }

    /**
     * @param mixed $documents
     */
    public function setDocuments($documents)
    {
        $this->documents = $documents;
    }

    public function __toString()
    {
        return $this->name;
    }



}

