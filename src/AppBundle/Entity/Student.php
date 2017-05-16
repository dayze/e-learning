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
     * @ORM\OneToMany(targetEntity="QcmBundle\Entity\Score", mappedBy="student", cascade={"persist"})
     */
    private $score;

    /**
     * @ORM\ManyToMany(targetEntity="Section", mappedBy="students")
     */
    private $sections;


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

    /**
     * @return mixed
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param mixed $score
     */
    public function setScore($score)
    {
        $this->score = $score;
    }

}