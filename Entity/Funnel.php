<?php

namespace Synd\MetricsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="metrics_funnel")
 */
class Funnel
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    protected $id;
    
    /**
     * @ORM\OneToMany(targetEntity="FunnelEvent", mappedBy="funnel")
     */
    protected $events;
    
    public function __construct()
    {
        $this->events = new ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * Add events
     *
     * @param Synd\MetricsBundle\Entity\FunnelEvent $events
     */
    public function addFunnelEvent(\Synd\MetricsBundle\Entity\FunnelEvent $events)
    {
        $this->events[] = $events;
    }

    /**
     * Get events
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getEvents()
    {
        return $this->events;
    }
}