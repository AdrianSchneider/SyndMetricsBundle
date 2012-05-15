<?php

namespace Synd\MetricsBundle\Listener;

use Synd\MetricsBundle\Tracker\Tracker;
use Symfony\Component\EventDispatcher\Event;

class TrackerListener
{
    /**
     * @var    Tracker
     */
    protected $tracker;
    
    /**
     * Brings deps into scope
     * @param    Tracker
     */
    public function __construct(Tracker $tracker)
    {
        $this->tracker = $tracker;
    }
    
    /**
     * Placeholder to show API
     * @param    Event        Event being executed
     */
    protected function track(Event $event)
    {
        throw new \BadMethodCallException("track() should never be called directly");
    }
    
    /**
     * Trigger track() while also passing the event name
     * @param    string        Method name ("track_$eventName")
     * @param    array         Arguments to track()
     */
    public function __call($method, array $args)
    {
        if (substr($method, 0, 6) != 'track_') {
            throw new RuntimeException('Method not found');
        }
        
        return $this->tracker->track($args[0], substr($method, 6));
    }
}