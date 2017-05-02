<?php

namespace QcmBundle\Entity;

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
}

