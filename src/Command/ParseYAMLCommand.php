<?php
namespace Docean\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\FormatterHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml as YamlParser;

class ParseYAMLCommand extends Command
{
    private $apps = null;


    public function __construct($name)
    {
        $this->apps = require_once ROOT_DIR . DS . 'data' . DS . 'apps.php';
        parent::__construct($name);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        if (empty($this->apps)) {
            $message = "Nothing todo do, /data/apps.php is empty";
            $output->writeln(sprintf(INFO_TEMPLATE, $message));
            return $output;
        }

        return $this->createYAMLFiles($output);
    }

    public function createYAMLFiles(OutputInterface $output)
    {

        $counter = 0;

        $exportPath = ROOT_DIR . DS . 'data' . DS . 'yaml' . DS . '%s.yaml';

        foreach ($this->apps as $app) {

            $yaml = YamlParser::dump($app['yaml'], 6);
            file_put_contents(sprintf($exportPath, $app['containerName']), $yaml);
            $counter++;
        }

        return $output;
    }
}