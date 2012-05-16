<?php

namespace Synd\MetricsBundle\Sync;

use Doctrine\ORM\EntityManager;
use Synd\MetricsBundle\Repository\EventRepository;
use Synd\MetricsBundle\Repository\FunnelRepository;

class SyncEventData
{
    /**
     * @var    Doctrine\ORM\EntityManager
     */
    protected $em;
    
    /**
     * @var    Synd\MetricsBundle\Repository\EventRepository
     */
    protected $eventRepository;
    
    /**
     * @var    Synd\MetricsBundle\Repository\FunnelRepository
     */
    protected $funnelRepository;
    
    public function __construct(EntityManager $em, EventRepository $eventRepository, FunnelRepository $funnelRepository)
    {
        $this->em = $em;
        $this->eventRepository = $eventRepository;
        $this->funnelRepository = $funnelRepository;
    }
    
    public function sync()
    {
       
    }
        
}