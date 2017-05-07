<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Document
 *
 * @ORM\Table(name="document")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DocumentRepository")
 */
class Document
{
    public function __construct()
    {
        $this->sections = new ArrayCollection();
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
     * @var string
     * @ORM\Column(name="path", type="string", length=255)
     * @Assert\NotBlank(message="Vous devez saisir un document")
     * @Assert\File(mimeTypes={ "application/pdf", "image/jpeg", "image/png" }, maxSize="3M")
     */
    private $path;

    /**
     * @var bool
     *
     * @ORM\Column(name="available", type="boolean")
     */
    private $available;

    /**
     * @ORM\ManyToMany(targetEntity="Section", mappedBy="documents", fetch="EAGER", cascade={"persist"})
     */
    private $sections;

    /**
     * @ORM\ManyToOne(targetEntity="CourseCategory", inversedBy="documents", cascade={"remove"})
     */
    private $courseCategory;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */

    private $type;

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
     * Set path
     *
     * @param string $path
     *
     * @return Document
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set available
     *
     * @param boolean $available
     *
     * @return Document
     */
    public function setAvailable($available)
    {
        $this->available = $available;

        return $this;
    }

    /**
     * Get available
     *
     * @return bool
     */
    public function getAvailable()
    {
        return $this->available;
    }

    /**
     * @return mixed
     */
    public function getSections()
    {
        return $this->sections;
    }

    public function addSection(Section $section)
    {
        $this->sections[] = $section;
        $section->addDocument($this);
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

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getCourseCategory()
    {
        return $this->courseCategory;
    }

    public function setCourseCategory($courseCategory)
    {
        $this->courseCategory = $courseCategory;
    }
}

