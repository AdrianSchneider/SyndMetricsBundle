<?php

namespace Synd\MetricsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="Synd\MetricsBundle\Repository\EventRepository")
 * @ORM\Table(name="metrics_event")
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="FunnelEvent", mappedBy="event")
     */
    protected $funnels;
    
    public function __construct()
    {
        $this->funnels = new ArrayCollection();
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

    /**
     * Add funnels
     *
     * @param Synd\MetricsBundle\Entity\FunnelEvent $funnels
     */
    public function addFunnelEvent(\Synd\MetricsBundle\Entity\FunnelEvent $funnels)
    {
        $this->funnels[] = $funnels;
    }

    /**
     * Get funnels
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getFunnels()
    {
        return $this->funnels;
    }
}