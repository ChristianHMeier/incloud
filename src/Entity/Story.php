<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Story
 *
 * @ORM\Table(name="story")
 * @ORM\Entity
 */
class Story
{    
     /**
     * @var int
     *
     * @ORM\Column(name="id", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=80, nullable=false)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="book_time", type="time", nullable=false)
     */
    private $bookTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="submit_date", type="datetime", nullable=false)
     */
    private $submitDate;
    
    function getId() 
    {
        return $this->id;
    }

    function getDescription() 
    {
        return $this->description;
    }

    function getBookTime(): \DateTime 
    {
        return $this->bookTime;
    }

    function getSubmitDate(): \DateTime 
    {
        return $this->submitDate;
    }

    function setId($id) 
    {
        $this->id = $id;
    }

    function setDescription($description) 
    {
        $this->description = $description;
    }

    function setBookTime(\DateTime $bookTime) 
    {
        $this->bookTime = $bookTime;
    }

    function setSubmitDate(\DateTime $submitDate) 
    {
        $this->submitDate = $submitDate;
    }

}
