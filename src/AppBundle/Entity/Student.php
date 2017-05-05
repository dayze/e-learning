<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Student
 * @ORM\Entity
 */

class Student extends User
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @ORM\ManyToMany(targetEntity="Section", mappedBy="students")
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


    public function setSection($sections)
    {
        $this->sections = $sections;
    }


    /**
     * @return mixed
     */
    public function getSections()
    {
        return $this->sections;
    }

}