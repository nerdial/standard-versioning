<?php namespace Nerdial\Standards\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Nerdial\Standards\Generator\ChangelogGenerator;

class GenerateChangelogCommand extends Command
{

    protected static $defaultName = 'generate:changelog';

    public function __construct()
    {
        parent::__construct();
    }
    protected function configure()
    {
        $this
        // the short description shown while running "php bin/console list"
        ->setDescription('')

        // the full command description shown when running the command with
        // the "--help" option
            ->setHelp('This command generates or overrides the changelog based on all commits history');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $listOfTags = \array_filter(\explode(\PHP_EOL, \shell_exec("git for-each-ref refs/tags --sort=-taggerdate --format='%(refname)' --count=2")));

        if (count($listOfTags) < 1) {
            throw new \Exception('You must have at least 2 tags to proceed.');
        }
        ChangelogGenerator::generateChanglogFile();

        // shell_exec("git commit --allow-empty -m  '  " . $type . ' : ' . $commitMessage . " '   ");
    }
}
