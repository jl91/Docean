<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT_DIR', __DIR__);
define("INFO_TEMPLATE", "<bg=blue;fg=yellow;options=bold;blink>%s</>");
define("WARNING_TEMPLATE", "<bg=yellow;fg=black;options=bold;blink>%s</>");
define("DANGER_TEMPLATE", "<bg=red;fg=white;options=bold;blink>%s</>");
define("SUCCESS_TEMPLATE", "<bg=green;fg=white;options=bold;blink>%s</>");

use Docean\Application\Application;
use Docean\Cofiguration\ApplicationConfiguration;

require_once './vendor/autoload.php';
$commands = require_once './data/commands.php';

$configuration = new ApplicationConfiguration();

$configuration->set('commands', $commands);

$application = new Application($configuration);

$application->run();
