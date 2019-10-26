<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require 'vendor/autoload.php';

define('ROOT_DIRECTORY', __DIR__);

$application = new Core\Application();
$application->run();