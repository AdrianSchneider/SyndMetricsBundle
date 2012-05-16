<?php

namespace Synd\MetricsBundle\Tracker;

use Synd\MetricsBundle\Entity\Event;
use Synd\MetricsBundle\Entity\CompletedEvent;
use Symfony\Component\EventDispatcher\Event as DispatchedEvent;
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
     * @param    Synd\MetricsBundle\Entity\Event
     * @param    Symfony\Component\EventDispatcher\Event
     */
    public function track(Event $event, DispatchedEvent $dispatchedEvent)
    {
        $completed = new CompletedEvent();
        $completed->setEvent($event);
        $completed->setSession($this->session->getId());
        $completed->setDate(new \DateTime());

        $this->em->persist($completed);
        $this->em->flush();
    }
}
