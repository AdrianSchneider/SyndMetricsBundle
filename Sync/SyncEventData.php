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
        
        $checkEvents  = $events;
        $checkFunnels = $funnels;
        
        $configuredEvents  = array();
        $configuredFunnels = array();
        
        foreach ($this->finder->getConfig() as $funnelName => $funnelConfig) {
            $configuredFunnels[] = $funnelName;
            
            $funnelEvents = $funnelConfig['funnel'];
            
            if (!isset($checkFunnels[$funnelName])) {
                $funnel = new Funnel();
                $funnel->setId($funnelName);
                $checkFunnels[$funnelName] = $funnel;
                $this->em->persist($funnel);
            } else {
                $funnel = $checkFunnels[$funnelName];
            }
            
            foreach ($funnelEvents as $order => $eventName) {
                $configuredEvents[] = $eventName;
                
                if (!isset($checkEvents[$eventName])) {
                    $event = new Event();
                    $event->setId($eventName);
                    $checkEvents[$eventName] = $event;
                } else {
                    $event = $checkEvents[$eventName];
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
        
        foreach ($funnels as $funnel) {
            if (!in_array($funnel->getId(), $configuredFunnels)) {
                $this->em->remove($funnel);
            }
        }
        
        foreach ($events as $event) {
            if (!in_array($event->getId(), $configuredEvents)) {
                $this->em->remove($event);
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