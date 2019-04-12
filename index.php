#!/usr/bin/env php

<?php

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Nerdial\Standards\Console\CommitCommand;
use Nerdial\Standards\Console\InitializationCommand;
use Nerdial\Standards\Console\GenerateChangelogCommand;

$app = new Application('Console App', 'v1.0.0');
$app->add(new CommitCommand());
$app->add(new InitializationCommand());
$app->add(new GenerateChangelogCommand());
$app->run();
