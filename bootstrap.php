<?php


use Docean\Application\Application;
use Docean\Cofiguration\ApplicationConfiguration;

require_once "./vendor/autoload.php";
$commands = require_once "./data/commands.php";

$configuration = new ApplicationConfiguration();

$configuration->set('commands', $commands);

$application = new Application($configuration);

$application->run();
