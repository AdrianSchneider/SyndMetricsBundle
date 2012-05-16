<?php

namespace Synd\MetricsBundle\Listener;

use Synd\MetricsBundle\Tracker\Tracker;
use Synd\MetricsBundle\Repository\EventRepository;
use Symfony\Component\EventDispatcher\Event;

class TrackerListener
{
    /**
     * @var    Tracker
     */
    protected $tracker;
    
    /**
     * @var    EventRepository
     */
    protected $eventRepository;
    
    /**
     * Brings deps into scope
     * @param    Synd\MetricsBundle\Tracker\Tracker
     * @param    Synd\MetricsBundle\Repository\EventRepository
     */
    public function __construct(Tracker $tracker, EventRepository $repository)
    {
        $this->tracker = $tracker;
        $this->eventRepository = $repository;
    }
    
    /**
     * Placeholder to show API
     * XXX we're unable to pass custom data through event manager, so __call is workaround
     * 
     * @param    Event        Event Dispatcher event 
     */
    protected function track_eventname(Event $event)
    {
        
    }
    
    /**
     * Trigger track() while also passing the event name
     * @param    string        Method name ("track_$eventName")
     * @param    array         Arguments to track()
     */
    public function __call($method, array $args)
    {
        if (substr($method, 0, 6) != 'track_') {
            throw new \RuntimeException(sprintf('"%s" is not a valid tracker method', $method));
        }
        
        $eventName = substr($method, 6);
        
        if (!$event = $this->eventRepository->find($eventName)) {
            throw new \InvalidArgumentException(sprintf('"%s" is not a valid trackable event', $eventName));
        }
        
        return $this->tracker->track($event, $args[0]);
    }
}