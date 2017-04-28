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

}