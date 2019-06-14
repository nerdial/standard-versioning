<?php namespace Nerdial\Standards\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Nerdial\Standards\Helper\YamlHelper;
use Nerdial\Standards\Helper\GitHelper;

class InitializationCommand extends Command
{

    protected static $defaultName = 'init';
    protected $defaultVersion = "0.1.0";
    protected $defaultTagFormat = "v";
    public function __construct()
    {
        parent::__construct();
    }
    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Adds a config file for the pacakge')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command initiate the project.')
            ->setDefinition(
                new InputDefinition([
                    new InputOption('start-from', 's', InputOption::VALUE_REQUIRED),
                    new InputOption('tag-format', 'f', InputOption::VALUE_REQUIRED) // "v" , "V" ,""
                ])
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $defaultVersionOption = 'start-from';
        $tagFormatOption = 'tag-format';

        if (!GitHelper::gitDirectoryExists()) {
            throw new \Exception('Make sure current direcory is a git repository by calling  "git init" ');
        }

        if (YamlHelper::fileExists()) {
            $output->writeln('<info>It seems there is already a file called moon.yaml </info>');
           return 0;  // zero code - exits successfully
        }

        $preferedTagFormat = $input->getOption($tagFormatOption);

        if (isset($preferedTagFormat)) {
            $this->modifyDefaultTagFormat($preferedTagFormat);
        }

        $output->writeln('<info> Creating moon.yaml file ... </info>');


        YamlHelper::createConfigFile($this->defaultTagFormat);

        $output->writeln('<info> A file called moon.yaml was created in the root directory </info>');


        if ($preferedVersion = $input->getOption($defaultVersionOption)) {
            $this->modifyDefaultVersion($preferedVersion);
        }

        // create first tag

        \shell_exec('git add moon.yaml && git commit -m "Create a moon.yaml file config" ');

        $output->writeln('<info> Added moon.yaml to git </info>');
        $output->writeln('<info> Commited moon.yaml file with default message "Create a moon.yaml file config" </info>');

        \shell_exec("git tag {$this->defaultTagFormat}{$this->defaultVersion} -a -m {$this->defaultVersion}");

        $output->writeln('<info> Created the first tag for versioning </info>');
    }

    protected function modifyDefaultVersion(string $defaultVersion)
    {
        $this->defaultVersion = $defaultVersion;
    }

    protected function modifyDefaultTagFormat(string $preferedTagFormat)
    {
        $this->defaultTagFormat = $preferedTagFormat;
    }
}
