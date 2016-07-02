#!/usr/bin/env php
<?php
// cli.php

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Andrej\Console\JQueryCommand;

$application = new Application();
$application->add(new JQueryCommand());
$application->run();
