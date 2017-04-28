<?php

namespace QcmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * QcmAnswer
 *
 * @ORM\Table(name="qcm_answer")
 * @ORM\Entity(repositoryClass="QcmBundle\Repository\QcmAnswerRepository")
 */
class QcmAnswer
{
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
     * @ORM\Column(name="response", type="string", length=255)
     */
    private $response;

    /**
     * @var bool
     *
     * @ORM\Column(name="isCorrect", type="boolean")
     */
    private $isCorrect;

    /**
     * @ORM\ManyToOne(targetEntity="QcmQuestion", inversedBy="qcmAnswers", cascade={"persist"})
     */
    private $qcmQuestion;

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
     * Set response
     *
     * @param string $response
     *
     * @return QcmAnswer
     */
    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Get response
     *
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Set isCorrect
     *
     * @param boolean $isCorrect
     *
     * @return QcmAnswer
     */
    public function setIsCorrect($isCorrect)
    {
        $this->isCorrect = $isCorrect;

        return $this;
    }

    /**
     * Get isCorrect
     *
     * @return bool
     */
    public function getIsCorrect()
    {
        return $this->isCorrect;
    }

    /**
     * @return mixed
     */
    public function getQcmQuestion()
    {
        return $this->qcmQuestion;
    }

    /**
     * @param mixed $qcmQuestion
     */
    public function setQcmQuestion($qcmQuestion)
    {
        $this->qcmQuestion = $qcmQuestion;
    }

}

