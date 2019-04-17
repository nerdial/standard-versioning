<?php namespace Nerdial\Standards\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PushReleaseCommand extends Command
{

    protected static $defaultName = 'push:release';

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
            ->setHelp('');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
       
    }



}
