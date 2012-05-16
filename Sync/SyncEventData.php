<?php

namespace Synd\MetricsBundle\Sync;

use Synd\MetricsBundle\Entity\Event;
use Synd\MetricsBundle\Entity\Funnel;
use Synd\MetricsBundle\Entity\FunnelEvent;
use Synd\MetricsBundle\Config\MetricsFinder;
use Synd\MetricsBundle\Repository\EventRepository;
use Synd\MetricsBundle\Repository\FunnelRepository;
use Doctrine\ORM\EntityManager;

class SyncEventData
{
    /**
     * @var    Synd\MetricsBundle\Config\MetricsFinder
     */
    protected $finder;
    
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
    
    /**
     * @param    Synd\MetricsBundle\Config\MetricsFinder
     * @param    Doctrine\ORM\EntityManager
     * @param    Synd\MetricsBundle\Repository\EventRepository
     * @param    Synd\MetricsBundle\Repository\FunnelRepository
     */
    public function __construct(MetricsFinder $finder, EntityManager $em, EventRepository $eventRepository, FunnelRepository $funnelRepository)
    {
        $this->finder = $finder;
        $this->em = $em;
        $this->eventRepository = $eventRepository;
        $this->funnelRepository = $funnelRepository;
    }
    
    /**
     * Updates the database with the latest metric configuration data
     */
    public function sync()
    {
        $events  = $this->indexCollectionById($this->eventRepository->findAll());
        $funnels = $this->indexCollectionById($this->funnelRepository->findAll()); 
        
        foreach ($this->finder->getConfig() as $funnelName => $funnelConfig) {
            $funnelEvents = $funnelConfig['funnel'];
            
            if (!isset($funnels[$funnelName])) {
                $funnel = new Funnel();
                $funnel->setId($funnelName);
                $this->em->persist($funnel);
            } else {
                $funnel = $funnels[$funnelName];
            }
            
            foreach ($funnelEvents as $order => $eventName) {
                if (!isset($events[$eventName])) {
                    $event = new Event();
                    $event->setId($eventName);
                } else {
                    $event = $events[$eventName];
                }
                
                $funnelEvent = null;
                foreach ($funnel->getEvents() as $funnelEventTest) {
                    if ($funnelEventTest->getEvent()->getId() == $eventName) {
                        $funnelEvent = $funnelEventTest;
                    }
                }
                
                if (!$funnelEvent) {
                    $funnelEvent = new FunnelEvent();
                    $funnelEvent->setFunnel($funnel);
                    $funnelEvent->setEvent($event);
                }
                
                $funnelEvent->setStep($order + 1);
                
                $this->em->persist($event);
                $this->em->persist($funnelEvent);
            }
        }
        
        $this->em->flush();
    }
    
    /**
     * Index an array of entiites by its id
     * @param    array        Entity Collection ; array(Entity, Entity2)
     * @return   array        Entity Collection ; array(id1 => Entity1, id2 => Entity2)
     */
    protected function indexCollectionById(array $collection)
    {
        $out = array();
        foreach ($collection as $entity) {
            $out[$entity->getId()] = $entity;
        }
        
        return $out;
    }
}