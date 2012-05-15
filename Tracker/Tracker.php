<?php

namespace Synd\MetricsBundle\Tracker;

use Synd\MetricsBundle\Entity\Metric;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Session;
use Doctrine\ORM\EntityManager;

class Tracker
{
    /**
     * @var    Session
     */
    protected $session;
    
    /**
     * @var    EntityManager
     */
    protected $em;
    
    /**
     * Brings deps into scope
     * @param    Session
     * @param    EventityManager
     */
    public function __construct(Session $session, EntityManager $em)
    {
        $this->session = $session;
        $this->em = $em;
    }
    
    /**
     * Stores a trackable metric
     * @param    Event
     * @param    string        Event Name
     */
    public function track(Event $event, $eventName)
    {
        $metric = new Metric();
        $metric->setEvent($eventName);
        $metric->setSession($this->session->getId());
        $metric->setDate(new \DateTime());

        $this->em->persist($metric);
        $this->em->flush();
    }
}
