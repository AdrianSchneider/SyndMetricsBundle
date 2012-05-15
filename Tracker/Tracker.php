<?php

namespace Synd\MetricsBundle\Tracker;

use Synd\MetricsBundle\Entity\Metric;
use Doctrine\ORM\EntityManager;

class Tracker
{
    /**
     * @var    EntityManager
     */
    protected $em;
    
    /**
     * Brings deps into scope
     * @param    EventityManager
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    /**
     * Stores a trackable metric
     * @param    string        Event Name
     */
    public function track($eventName)
    {
        $metric = new Metric();
        #$metric->setEvent($eventName);
        #$metric->setDate(new \DateTime());
        #$metric->setUser( null ); // TODO
        #$metric->setSession( null ); // TODO
        return;
        $this->em->persist($metric);
        $this->em->flush();
    }
}
