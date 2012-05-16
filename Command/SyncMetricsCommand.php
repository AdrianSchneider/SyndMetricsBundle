<?php

namespace Synd\MetricsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
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
        $this->getContainer()->get('synd_metrics.sync')->sync();
        $output->writeln("Metrics synchronized successfully.  It's advised to run <info>cache:clear</info> to ensure DIC is functioning.");
    }
}
