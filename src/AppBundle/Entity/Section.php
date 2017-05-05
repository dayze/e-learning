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
        $this->students = new ArrayCollection();
        $this->supervisors = new ArrayCollection();
        $this->documents = new ArrayCollection();
        $this->courses = new ArrayCollection();
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
     * @ORM\ManyToMany(targetEntity="Student", inversedBy="sections")
     */
    private $students;

    /**
     * @ORM\ManyToMany(targetEntity="Supervisor", inversedBy="sections")
     */
    private $supervisors;

    /**
     * @ORM\ManyToMany(targetEntity="Document", inversedBy="sections", cascade={"persist"})
     * @ORM\JoinTable(name="section_document")
     */

    private $documents;

    /**
     * @ORM\ManyToMany(targetEntity="Course", inversedBy="sections", cascade={"persist"})
     */
    private $courses;

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

    /**
     * @return mixed
     */
    public function getCourses()
    {
        return $this->courses;
    }

    /**
     * @param mixed $courses
     */
    public function setCourses($courses)
    {
        $this->courses = $courses;
    }

    /**
     * @return mixed
     */
    public function getStudents()
    {
        return $this->students;
    }

    /**
     * @param mixed $students
     */
    public function setStudents($students)
    {
        $this->students = $students;
    }

    public function addCourse(Course $course)
    {
        $this->courses->add($course);
        return $this;
    }

    public function removeCourse(Course $course)
    {
        $this->courses->removeElement($course);
    }

    public function addStudent(Student $student)
    {
        $this->students->add($student);
        return $this;
    }

    public function removeStudent(Student $student)
    {
        $this->students->removeElement($student);
    }

    public function addSupervisor(Supervisor $supervisor)
    {
        $this->supervisors->add($supervisor);
        return $this;
    }

    public function removeSupervisor(Supervisor $supervisor)
    {
        $this->supervisors->removeElement($supervisor);
    }

    /**
     * @return mixed
     */
    public function getSupervisors()
    {
        return $this->supervisors;
    }

    /**
     * @param mixed $supervisors
     */
    public function setSupervisors($supervisors)
    {
        $this->supervisors = $supervisors;
    }


}

