#!/usr/bin/env php
<?php
// cli.php

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;

$application = new Application();
$application->run();
