<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Course
 *
 * @ORM\Table(name="course")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CourseRepository")
 */
class Course
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
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Supervisor", inversedBy="courses")
     */
    private $supervisor;

    /**
     * @ORM\OneToMany(targetEntity="CourseCategory", mappedBy="course", cascade={"remove"})
     */
    private $courseCategories;

    /**
     * @ORM\ManyToMany(targetEntity="Section", mappedBy="courses", cascade={"persist"})
     */
    private $sections;


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
     * @return Course
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
     * @return mixed
     */
    public function getSupervisor()
    {
        return $this->supervisor;
    }

    /**
     * @param mixed $supervisor
     */
    public function setSupervisor($supervisor)
    {
        $this->supervisor = $supervisor;
    }

    /**
     * @return mixed
     */
    public function getCourseCategories()
    {
        return $this->courseCategories;
    }

    /**
     * @param mixed $courseCategories
     */
    public function setCourseCategories($courseCategories)
    {
        $this->courseCategories = $courseCategories;
    }

    public function addSection(Section $section)
    {
        $section->addCourse($this);
        $this->sections[] = $section;
    }

    public function removeSection(Section $section)
    {
        $this->sections->removeElement($section);
        $section->removeCourse($section);
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

    public function __toString()
    {
        return $this->name;
    }

}

