<?php

namespace Atk\RegistrationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventDate
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Atk\RegistrationBundle\Entity\EventDateRepository")
 */
class EventDate
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
     * @var \DateTime
     *
     * @ORM\Column(name="eventdate", type="date")
     */
    private $eventdate;


    /**
     * Many-To-One
     *
     * @var Event $event
     *
     * @ORM\ManyToOne(targetEntity="Event")
     * @ORM\JoinColumn(name="event", referencedColumnName="id")
     * 
     */
    private $event;

    /**
     * @var integer
     *
     * @ORM\Column(name="timeIncrement", type="integer")
     */
    private $timeIncrement;

    /**
     * Many-To-One
     *
     * @var DateStatus $status
     *
     * @ORM\ManyToOne(targetEntity="DateStatus")
     * @ORM\JoinColumn(name="status", referencedColumnName="id")
     * 
     */ 
    private $status;

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
     * Set eventdate
     *
     * @param \DateTime $eventdate
     * @return EventDate
     */
    public function setEventdate($eventdate)
    {
        $this->eventdate = $eventdate;
    
        return $this;
    }

    /**
     * Get eventdate
     *
     * @return \DateTime 
     */
    public function getEventdate()
    {
        return $this->eventdate;
    }

    /**
     * Set event
     *
     * @param integer $event
     * @return EventDate
     */
    public function setEvent($event)
    {
        $this->event = $event;
    
        return $this;
    }

    /**
     * Get event
     *
     * @return integer 
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set timeIncrement
     *
     * @param integer $timeIncrement
     * @return EventDate
     */
    public function setTimeIncrement($timeIncrement)
    {
        $this->timeIncrement = $timeIncrement;
    
        return $this;
    }

    /**
     * Get timeIncrement
     *
     * @return integer 
     */
    public function getTimeIncrement()
    {
        return $this->timeIncrement;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return EventDate
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }
}
