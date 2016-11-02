<?php


namespace Docean;

use Docean\Cofiguration\Configuration;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Command\Command;

class Application
{
    private $console = null;
    private $commands = null;

    public function __construct($name = 'Docean App', Configuration $configuration = null)
    {
        $version = $this->getVersion();
        $this->console = new ConsoleApplication($name, $version);
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

    private function getVersion()
    {
        $versions = trim(shell_exec('git tag'));
        $pieces = explode(PHP_EOL, $versions);
        $version = end($pieces);
        return $version;
    }

    public function run($commands)
    {
        $this->console->addCommands($this->commands);
        return $this->console->run($input, $output);
    }

}