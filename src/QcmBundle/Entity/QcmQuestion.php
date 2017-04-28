<?php

namespace QcmBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * QcmQuestion
 *
 * @ORM\Table(name="qcm_question")
 * @ORM\Entity(repositoryClass="QcmBundle\Repository\QcmQuestionRepository")
 */
class QcmQuestion
{

    public function __construct()
    {
        $this->qcmAnswers = new ArrayCollection();
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
     * @ORM\Column(name="imgPath", type="string", length=255, nullable=true)
     */
    private $imgPath;

    /**
     * @var string
     *
     * @ORM\Column(name="question", type="string", length=255)
     */
    private $question;

    /**
     * @ORM\ManyToOne(targetEntity="Qcm")
     */
    private $qcm;

    /**
     * @ORM\OneToMany(targetEntity="QcmAnswer", mappedBy="qcmQuestion", cascade={"persist"})
     */
    private $qcmAnswers;

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
     * Set imgPath
     *
     * @param string $imgPath
     *
     * @return QcmQuestion
     */
    public function setImgPath($imgPath)
    {
        $this->imgPath = $imgPath;

        return $this;
    }

    /**
     * Get imgPath
     *
     * @return string
     */
    public function getImgPath()
    {
        return $this->imgPath;
    }

    /**
     * Set question
     *
     * @param string $question
     *
     * @return QcmQuestion
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @return mixed
     */
    public function getQcm()
    {
        return $this->qcm;
    }

    /**
     * @param mixed $qcm
     */
    public function setQcm($qcm)
    {
        $this->qcm = $qcm;
    }

    /**
     * @return mixed
     */
    public function getQcmAnswers()
    {
        return $this->qcmAnswers;
    }

    /**
     * @param mixed $qcmAnswers
     */
    public function setQcmAnswers($qcmAnswers)
    {
        $this->qcmAnswers = $qcmAnswers;
    }
}

