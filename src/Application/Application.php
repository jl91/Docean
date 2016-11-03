<?php


namespace Docean\Application;

use Docean\Cofiguration\ConfigurationInterface;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Application extends ConsoleApplication
{
    private $commands = null;

    const COMMANDS = 'commands';

    public function __construct(ConfigurationInterface $configuration = null)
    {
        $version = $this->getLastTag();
        parent::__construct('Docean App', $version);
        $this->commands = $this->getCommands($configuration);
    }

    private function getCommands(ConfigurationInterface $configuration = null) : array
    {
        $commands = !empty($configuration[self::COMMANDS]) ? $configuration[self::COMMANDS] : null;

        $collection = [];

        if (empty($commands)) {
            return $collection;
        }

        foreach ($commands->toArray()['commands'] as $name => $value) {
            $command = new $value($name);
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