<?php

namespace Synd\MetricsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="Synd\MetricsBundle\Repository\FunnelRepository")
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

    /**
     * Set id
     *
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get id
     *
     * @return string 
     */
    public function getId()
    {
        return $this->id;
    }
}