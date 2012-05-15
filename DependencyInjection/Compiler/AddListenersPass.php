<?php

namespace Synd\MetricsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Parser;

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
        foreach ($this->getBundleDirectories($container) as $dir) {
            $events = array_merge($events, $this->getBundleEvents($dir));
        }

        return $events;
    }
    
    /**
     * Grabs a list of all registered bundle directories from the container
     * @param    ContainerBuilder
     * @return   array        Directories containing active bundles
     */
    protected function getBundleDirectories($container)
    {
        $dirs = array();
        foreach ($container->getParameter('kernel.bundles') as $bundleName) {
            $refClass  = new \ReflectionClass($bundleName);
            $dirs[] = pathinfo($refClass->getFileName(), PATHINFO_DIRNAME);
        }
        
        return $dirs;
    }
    
    /**
     * Grabs a list of all events (trackable metrics) for a given bundle directory
     * Assumes Resources/config/metrics.yml
     * 
     * @param    string        Bundle directory
     * @return   array         List of events to track, empty array if not found
     */
    protected function getBundleEvents($bundleDir)
    {
        if (!file_exists($configFile = "$bundleDir/Resources/config/metrics.yml")) {
            return array();
        }

        $events = array();
        $parser = new Parser();
        $config = $parser->parse(file_get_contents($configFile));
        
        foreach ($config['metrics'] as $groupName => $groupConfig) {
            foreach ($groupConfig['funnel'] as $event) {
                $events[] = $event;
            }
        }

        return $events;
    }
}