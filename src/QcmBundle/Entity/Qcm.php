<?php

namespace QcmBundle\Entity;

use AppBundle\Entity\CourseCategory;
use AppBundle\Entity\DocRelation;
use AppBundle\Entity\Section;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Qcm
 *
 * @ORM\Table(name="qcm")
 * @ORM\Entity(repositoryClass="QcmBundle\Repository\QcmRepository")
 */
class Qcm
{
    public function __construct()
    {
        $this->qcmQuestions = new ArrayCollection();
        $this->docRelation = new ArrayCollection();
        $this->date = new \DateTime('now');
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
     * @ORM\OneToMany(targetEntity="QcmQuestion", mappedBy="qcm", cascade={"persist", "remove"})
     */
    private $qcmQuestions;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\DocRelation", mappedBy="qcm", cascade={"persist"})
     */
    private $docRelation;

    /**
     * @ORM\OneToMany(targetEntity="Score", mappedBy="qcm", cascade={"persist"})
     */
    private $score;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var bool
     *
     * @ORM\Column(name="isEvaluated", type="boolean")
     */
    private $isEvaluated;


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
     * @return Qcm
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
    public function getQcmQuestions()
    {
        return $this->qcmQuestions;
    }

    public function addQcmQuestion(QcmQuestion $qcmQuestion)
    {
        $qcmQuestion->addQcm($this);
        $this->qcmQuestions->add($qcmQuestion);
    }

    public function removeQcmQuestion(QcmQuestion $qcmQuestion)
    {
        $this->qcmQuestions->removeElement($qcmQuestion);
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

    public function addDocRelation(DocRelation $docRelation)
    {
        $this->docRelation->add($docRelation);
        $docRelation->setQcm($this);
    }

    public function removeDocRelation(DocRelation $docRelation)
    {

    }

    /**
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
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
     * @return bool
     */
    public function isIsEvaluated()
    {
        return $this->isEvaluated;
    }

    /**
     * @param bool $isEvaluated
     */
    public function setIsEvaluated($isEvaluated)
    {
        $this->isEvaluated = $isEvaluated;
    }


}

