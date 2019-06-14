<?php namespace Nerdial\Standards\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Nerdial\Standards\Helper\GitHelper;

class TagCommand extends Command
{

    protected static $defaultName = 'tag';

    public function __construct()
    {
        parent::__construct();
    }
    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Creates a new tag for a git project, you could pass major, minor or patch parameter')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to create a new tag')
            ->setDefinition(
                new InputDefinition([
                    new InputOption('message', 'm', InputOption::VALUE_REQUIRED, 'commit message for new tag', 'New tag added to vsc'),
                    new InputArgument('type', InputArgument::REQUIRED, 'ranger'),
                ])
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        if (!GitHelper::gitDirectoryExists()) {
            throw new \Exception('Make sure current direcory is a git repository by calling  "git init" ');
        }


        $type = $input->getArgument('type');

        if (!\in_array($type, ['major', 'minor', 'patch'])) {
            throw new \Exception('Type argument must be one of these values : major, minor, patch');
        }

        $nextVersion = $this->getNextVersion($type);

        $commitMessage = $input->getOption('message');
        \shell_exec("git tag $nextVersion -a -m $nextVersion");

        $output->writeln("<info> New tag created {$nextVersion} </info>");

        //shell_exec("git commit --allow-empty -m  ' ({$type}): {$commitMessage}");
    }

    protected function getLatestVersion()
    {
        $lastTag = \shell_exec("git for-each-ref refs/tags --sort=-taggerdate --format='%(refname)' --count=1");
        $unprocessedTag = \explode('/', $lastTag);
        $latestVersion = \array_pop($unprocessedTag);

        return \explode('.', \str_replace('v', '', $latestVersion));
    }

    protected function getNextVersion($type)
    {
        [$major, $minor, $patch] = $this->getLatestVersion();

        if ($type == 'major') {
            $nextVersion = ((int)$major + 1) . '.0.0';
        } else if ($type == 'minor') {
            $nextVersion = $major . '.' . ((int)$minor + 1) . '.0';
        } else {
            $nextVersion = $major . '.' . $minor . '.' . ((int)$patch + 1);
        }
        return "v$nextVersion";
    }
}
