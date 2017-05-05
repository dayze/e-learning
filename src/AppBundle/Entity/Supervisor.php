<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Supervisor
 *
 * @ORM\Entity
 */

class Supervisor extends User
{

    public function __construct()
    {
        $this->setRoles(["ROLE_SUPERVISOR"]);
        parent::__construct();
    }

    /**
     * @ORM\OneToMany(targetEntity="Course", mappedBy="supervisor")
     */
    private $courses;


    /**
     * @ORM\ManyToMany(targetEntity="Section", mappedBy="supervisors")
     */
    private $sections;

    /*public function addSection(Section $section)
    {
        $this->sections[] = $section;
        $section->addUser($this);
        return $this;
    }

    public function removeSection(Section $section)
    {
        $this->sections->removeElement($section);
        $section->removeDocument($this);
    }*/


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
}