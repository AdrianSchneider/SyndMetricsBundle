<?php

namespace Synd\MetricsBundle\Config;

use Symfony\Component\Yaml\Parser;

class MetricsFinder
{
    /**
     * @var     array        Bundles
     */
    protected $bundles;
    
    /**
     * Active bundle classes
     * @param    array        Active bundle classes (%kernel.bundles%)
     */
    public function __construct(array $bundles) 
    {
        $this->bundles = $bundles;
    }
    
    /**
     * Fetches all metric configuration from active bundles
     * @return    array        Metric configurations
     */
    public function getConfig()
    {
        $config = array();
        foreach ($this->getBundleDirectories() as $dir) {
            $config = array_merge($config, $this->getBundleConfig($dir));
        }
        
        return $config;
    }
    
    /**
     * Grabs a list of all registered bundle directories from the container
     * @return   array        Directories containing active bundles
     */
    protected function getBundleDirectories()
    {
        $dirs = array();
        foreach ($this->bundles as $bundleName) {
            $refClass  = new \ReflectionClass($bundleName);
            $dirs[] = pathinfo($refClass->getFileName(), PATHINFO_DIRNAME);
        }
    
        return $dirs;
    }
    
    /**
     * Fetches the config data for a given bundle
     * TODO other format support
     * 
     * @param    string        Bundle directory
     * @return   array         Metric configurations (empty array if none found)
     */
    protected function getBundleConfig($bundleDir)
    {
        if (!file_exists($configFile = "$bundleDir/Resources/config/metrics.yml")) {
            return array();
        }

        $parser = new Parser();
        $config = $parser->parse(file_get_contents($configFile));
        return $config['metrics'];
    }
}