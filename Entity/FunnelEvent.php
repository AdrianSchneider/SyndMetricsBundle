<?php

namespace Synd\MetricsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="metrics_funnel_event")
 */
class FunnelEvent
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Funnel", inversedBy="events")
     * @ORM\JoinColumn(name="funnel_id", referencedColumnName="id")
     */
    protected $funnel;
    
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="funnels")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     */
    protected $event;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $step;

    /**
     * Set step
     *
     * @param integer $step
     */
    public function setStep($step)
    {
        $this->step = $step;
    }

    /**
     * Get step
     *
     * @return integer 
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * Set funnel
     *
     * @param Synd\MetricsBundle\Entity\Funnel $funnel
     */
    public function setFunnel(\Synd\MetricsBundle\Entity\Funnel $funnel)
    {
        $this->funnel = $funnel;
    }

    /**
     * Get funnel
     *
     * @return Synd\MetricsBundle\Entity\Funnel 
     */
    public function getFunnel()
    {
        return $this->funnel;
    }

    /**
     * Set event
     *
     * @param Synd\MetricsBundle\Entity\Event $event
     */
    public function setEvent(\Synd\MetricsBundle\Entity\Event $event)
    {
        $this->event = $event;
    }

    /**
     * Get event
     *
     * @return Synd\MetricsBundle\Entity\Event 
     */
    public function getEvent()
    {
        return $this->event;
    }
}