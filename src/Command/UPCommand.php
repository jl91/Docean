<?php
namespace Docean\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UPCommand extends Command
{

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $outputFormmater = new OutputFormatter();
        $outputFormmater->setDecorated(true);
        $outputFormmater->format("AAAAAAAAAA");
        $output->setFormatter($outputFormmater);
        $output->writeln("UP");
    }

}