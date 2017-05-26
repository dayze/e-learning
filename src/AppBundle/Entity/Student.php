<?php


namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Student
 * @ORM\Entity
 */
class Student extends User
{
    public function __construct()
    {
        $this->sections = new ArrayCollection();
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
    * @ORM\OneToMany(targetEntity="StudentBundle\Entity\RetrieveTime", mappedBy="students", cascade={"persist"})
    */
    private $retrieveTime;

    private $totalRetrieveTime;



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

    public function addSection(Section $section)
    {
        $this->sections[] = $section;
        $section->addStudent($this);
    }

    public function removeSection(Section $section)
    {
        $this->sections->removeElement($section);
        $section->removeStudent($this);
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
    public function getRetrieveTimes()
    {
        return $this->retrieveTime;
    }

    /**
     * @param mixed $retrieveTimes
     */
    public function setRetrieveTimes($retrieveTime)
    {
        $this->retrieveTime = $retrieveTime;
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
    public function getTotalRetrieveTime()
    {
        return $this->totalRetrieveTime;
    }

    /**
     * @param mixed $totalRetrieveTime
     */
    public function setTotalRetrieveTime($totalRetrieveTime)
    {
        $this->totalRetrieveTime = $totalRetrieveTime;
    }

    /**
     * @return mixed
     */
    public function getRetrieveTime()
    {
        return $this->retrieveTime;
    }

    /**
     * @param mixed $retrieveTime
     */
    public function setRetrieveTime($retrieveTime)
    {
        $this->retrieveTime = $retrieveTime;
    }


}