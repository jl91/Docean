<?php


namespace Docean\Application;

use Docean\Cofiguration\Configuration;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Application extends ConsoleApplication
{
    private $commands = null;

    public function __construct(Configuration $configuration = null)
    {
        $version = $this->getLastTag();
        parent::__construct('Docean App', $version);
        $this->commands = $this->getCommands($configuration);
    }

    private function getCommands(Configuration $configuration = null) : array
    {
        $commands = isset($configuration['commands']) ? $configuration['commands'] : null;

        if (empty($commands)) {
            return [];
        }

        $collection = [];

        foreach ($commands as $name => $value) {
            $command = new Command($name);
            $collection[] = $command;
        }

        return $collection;
    }

    public function getLastTag()
    {
        $tags = trim(shell_exec('git tag'));
        $pieces = explode(PHP_EOL, $tags);
        $tag = end($pieces);
        return $tag;
    }

    public function run(InputInterface $input = null, OutputInterface $output = null)
    {
        $this->addCommands($this->commands);
        return parent::run($input, $output);
    }

}