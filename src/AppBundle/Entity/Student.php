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

    /**
    * @ORM\ManyToMany(targetEntity="StudentBundle\Entity\Action", mappedBy="students", cascade={"persist"})
    */
    private $actions;

    /**
    * @ORM\ManyToMany(targetEntity="StudentBundle\Entity\RetrieveTime", mappedBy="students", cascade={"persist"})
    */
    private $retriveTimes;


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

    /**
     * @return mixed
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * @param mixed $actions
     */
    public function setActions($actions)
    {
        $this->actions = $actions;
    }

    /**
     * @return mixed
     */
    public function getRetriveTimes()
    {
        return $this->retriveTimes;
    }

    /**
     * @param mixed $retriveTimes
     */
    public function setRetriveTimes($retriveTimes)
    {
        $this->retriveTimes = $retriveTimes;
    }

}