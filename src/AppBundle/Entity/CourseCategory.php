<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use QcmBundle\Entity\Qcm;

/**
 * Course
 *
 * @ORM\Table(name="course_category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CourseCategoryRepository")
 */
class CourseCategory
{
    public function __construct()
    {
        $this->documents = new ArrayCollection();
        $this->qcms = new ArrayCollection();
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
     * @ORM\ManyToOne(targetEntity="Course", inversedBy="courseCategories")
     */
    private $course;

    /**
     * @ORM\OneToMany(targetEntity="DocRelation", mappedBy="courseCategory", cascade={"persist"})
     */
    private $docRelation;

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
     * @return $this
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
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * @param mixed $course
     */
    public function setCourse($course)
    {
        $this->course = $course;
    }


    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDocRelation()
    {
        return $this->docRelation;
    }

    /**
     * @param mixed $docRelation
     */
    public function setDocRelation($docRelation)
    {
        $this->docRelation = $docRelation;
    }

}

