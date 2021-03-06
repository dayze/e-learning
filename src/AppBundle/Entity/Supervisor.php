<?php


namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
        $this->sections = new ArrayCollection();
    }

    /**
     * @ORM\OneToMany(targetEntity="Course", mappedBy="supervisor")
     */
    private $courses;


    /**
     * @ORM\ManyToMany(targetEntity="Section", mappedBy="supervisors")
     */
    private $sections;

    public function addSection(Section $section)
    {
        $this->sections[] = $section;
        $section->addSupervisor($this);
        return $this;
    }

    public function removeSection(Section $section)
    {
        $this->sections->removeElement($section);
        $section->removeSupervisor($this);
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