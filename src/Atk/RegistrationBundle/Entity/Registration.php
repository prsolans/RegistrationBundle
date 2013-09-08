<?php

namespace Atk\RegistrationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Registration
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Atk\RegistrationBundle\Entity\RegistrationRepository")
 */
class Registration
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var integer
     *
     * @ORM\Column(name="eventdate", type="integer")
     */
    private $eventdate;

    /**
     * @var integer
     *
     * @ORM\Column(name="timeslot", type="integer")
     */
    private $timeslot;

    /**
     * @var string
     *
     * @ORM\Column(name="add1", type="string", length=255)
     */
    private $add1;

    /**
     * @var string
     *
     * @ORM\Column(name="add2", type="string", length=255)
     */
    private $add2;

    /**
     * @var string
     *
     * @ORM\Column(name="add3", type="string", length=255)
     */
    private $add3;

    /**
     * @var string
     *
     * @ORM\Column(name="add4", type="string", length=255)
     */
    private $add4;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return Registration
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    
        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return Registration
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    
        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Registration
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set eventdate
     *
     * @param integer $eventdate
     * @return Registration
     */
    public function setEventdate($eventdate)
    {
        $this->eventdate = $eventdate;
    
        return $this;
    }

    /**
     * Get eventdate
     *
     * @return integer 
     */
    public function getEventdate()
    {
        return $this->eventdate;
    }

    /**
     * Set timeslot
     *
     * @param integer $timeslot
     * @return Registration
     */
    public function setTimeslot($timeslot)
    {
        $this->timeslot = $timeslot;
    
        return $this;
    }

    /**
     * Get timeslot
     *
     * @return integer 
     */
    public function getTimeslot()
    {
        return $this->timeslot;
    }

    /**
     * Set add1
     *
     * @param string $add1
     * @return Registration
     */
    public function setAdd1($add1)
    {
        $this->add1 = $add1;
    
        return $this;
    }

    /**
     * Get add1
     *
     * @return string 
     */
    public function getAdd1()
    {
        return $this->add1;
    }

    /**
     * Set add2
     *
     * @param string $add2
     * @return Registration
     */
    public function setAdd2($add2)
    {
        $this->add2 = $add2;
    
        return $this;
    }

    /**
     * Get add2
     *
     * @return string 
     */
    public function getAdd2()
    {
        return $this->add2;
    }

    /**
     * Set add3
     *
     * @param string $add3
     * @return Registration
     */
    public function setAdd3($add3)
    {
        $this->add3 = $add3;
    
        return $this;
    }

    /**
     * Get add3
     *
     * @return string 
     */
    public function getAdd3()
    {
        return $this->add3;
    }

    /**
     * Set add4
     *
     * @param string $add4
     * @return Registration
     */
    public function setAdd4($add4)
    {
        $this->add4 = $add4;
    
        return $this;
    }

    /**
     * Get add4
     *
     * @return string 
     */
    public function getAdd4()
    {
        return $this->add4;
    }
}
