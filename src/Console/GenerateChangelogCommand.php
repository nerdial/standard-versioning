<?php namespace Nerdial\Standards\Console;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateChangelogCommand extends Command
{
    
    protected static $defaultName = 'init';

    public function __construct()
    {
        parent::__construct();
    }
    protected function configure()
    {
        $this
        // the short description shown while running "php bin/console list"
        ->setDescription('Add new CHANGELOG.md file')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command generates or overrides the changelog based on all commits history');
       
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
    

    }
}