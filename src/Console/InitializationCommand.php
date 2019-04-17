<?php namespace Nerdial\Standards\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class InitializationCommand extends Command
{

    protected static $defaultName = 'init';
    protected $defaultVersion = "0.1.0";
    public function __construct()
    {
        parent::__construct();
    }
    protected function configure()
    {
        $this
        // the short description shown while running "php bin/console list"
        ->setDescription('Add a config file for the pacakge')

        // the full command description shown when running the command with
        // the "--help" option
            ->setHelp('This command initiate the project.')
            ->setDefinition(
                new InputDefinition([
                    new InputOption('start-from', InputOption::VALUE_REQUIRED),

                ])
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $defaultVersionOption = 'start-from';

        if ($preferedVersion = $input->getOption($defaultVersionOption)) {
            $this->modifyDefaultVersion($preferedVersion);
        }

        // create first tag

        shell_exec("git tag v{$this->defaultVersion} -a -m {$this->defaultVersion}");

    }

    protected function modifyDefaultVersion(string $defaultVersion)
    {
        $this->defaultVersion = $defaultVersion;
    }
}
