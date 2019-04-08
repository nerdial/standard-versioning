#!/usr/bin/env php

<?php

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Nerdial\Standards\Console\GeneratorCommand;

$app = new Application('Console App', 'v1.0.0');
$app->add(new GeneratorCommand());
$app->run();
