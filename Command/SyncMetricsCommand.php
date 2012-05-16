<?php

namespace Synd\MetricsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SyncMetricsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('synd:metrics:sync')
            ->setDescription('Updates event/funnel configuration from configuration');
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $eventRepository = $this->container->get('synd_metrics.event_repository');
    }
}
