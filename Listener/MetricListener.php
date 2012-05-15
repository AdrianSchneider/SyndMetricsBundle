<?php

namespace Synd\MetricsBundle\Listener;

use Synd\MetricsBundle\Listener\TrackerListener;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;

class MetricListener
{
    /**
     * @var    EventDispatcher
     */
    protected $dispatcher;
    
    /**
     * @var    TrackerListener
     */
    protected $listener;
    
    /**
     * Brings deps into scope
     * @param    EventDispatcher
     * @param    TrackerListener
     */
    public function __construct(EventDispatcherInterface $dispatcher, TrackerListener $listener)
    {
        $this->dispatcher = $dispatcher;
        $this->listener = $listener;
    }
    
    /**
     * Registers our tracker to listen to an event dynamically (typically called via DIC)
     * @param    string        Event Name
     */
    public function addListenedEvent($eventName)
    {
        $this->dispatcher->addListener($eventName, array($this->listener, 'track_' . $eventName));
    }
    
    /**
     * Placed to trigger a callback
     */
    public function onKernelRequest(Event $event)
    {
        
    }
}