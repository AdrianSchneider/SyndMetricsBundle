<?php

namespace Synd\MetricsBundle;

use Synd\MetricsBundle\DependencyInjection\Compiler\AddListenersPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SyndMetricsBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new AddListenersPass());
    }
}