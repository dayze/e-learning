<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DocRelation
 *
 * @ORM\Table(name="doc_relation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DocRelationRepository")
 *
 */
class DocRelation
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
     * @ORM\ManyToOne(targetEntity="Section", inversedBy="docRelation", cascade={"persist"})
     */
    private $section;

    /**
     * @ORM\ManyToOne(targetEntity="Document", inversedBy="docRelation", cascade={"persist"})
     */
    private $document;

    /**
     * @ORM\ManyToOne(targetEntity="CourseCategory", inversedBy="docRelation", cascade={"persist"})
     */
    private $courseCategory;

    /**
     * @var bool
     *
     * @ORM\Column(name="available", type="boolean")
     */
    private $available;

    /**
     * @ORM\ManyToOne(targetEntity="Course", inversedBy="docRelation", cascade={"persist"})
     */
    private $course;

    /**
     * @ORM\ManyToOne(targetEntity="QcmBundle\Entity\Qcm", inversedBy="docRelation", cascade={"persist"})
     */
    private $qcm;


    /**
     * @return mixed
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * @param mixed $section
     */
    public function setSection($section)
    {
        $this->section = $section;
    }

    /**
     * @return mixed
     */
    public function getCourseCategory()
    {
        return $this->courseCategory;
    }

    /**
     * @param mixed $courseCategory
     */
    public function setCourseCategory($courseCategory)
    {
        $this->courseCategory = $courseCategory;
    }

    /**
     * @return mixed
     */
    public function getAvailable()
    {
        return $this->available;
    }

    /**
     * @param mixed $available
     */
    public function setAvailable($available)
    {
        $this->available = $available;
    }

    /**
     * @return mixed
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @param mixed $document
     */
    public function setDocument($document)
    {
        $this->document = $document;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * @param mixed $course
     */
    public function setCourse($course)
    {
        $this->course = $course;
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

}

