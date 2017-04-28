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