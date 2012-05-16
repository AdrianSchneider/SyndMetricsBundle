<?php

namespace Synd\MetricsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class AddListenersPass implements CompilerPassInterface
{
    /**
     * Registers our metric listen to listen to all events found in bundle configuration
     * @param    ContainerBuilder
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('synd_metrics.metric_listener')) {
            return;
        }
        
        $definition = $container->getDefinition('synd_metrics.metric_listener');
        
        foreach ($this->getEvents($container) as $eventName) {
            $definition->addMethodCall('addListenedEvent', array($eventName));
        }
    }
    
    /**
     * Grabs all raw event names from the system's bundles
     * @param    ContainerBuilder
     * @return   array        Event names to register
     */
    protected function getEvents(ContainerBuilder $container)
    {
        $events = array();
        
        foreach ($container->get('synd_metrics.finder')->getConfig() as $groupName => $groupConfig) {
            foreach ($groupConfig['funnel'] as $event) {
                $events[] = $event;
            }
        }

        return $events;
    }
}