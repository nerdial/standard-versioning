<?php namespace Nerdial\Standards\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CommitCommand extends Command
{

    protected static $defaultName = 'commit';

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
            ->setHelp('This command allows you to create a changelog file...')
            ->setDefinition(
                new InputDefinition([
                    new InputOption('message', 'm', InputOption::VALUE_REQUIRED, 'commit message for new tag', 'New tag added to vsc'),
                    new InputArgument('type', InputArgument::REQUIRED, 'ranger'),
                ])
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $type = $input->getArgument('type');

        if (!in_array($type, ['major', 'minor', 'patch'])) {
            throw new \Exception('Type argument must be one of these values : major, minor, patch');
        }

        $nextVersion = $this->getNextVersion($type);

        $commitMessage = $input->getOption('message');
        shell_exec("git tag $nextVersion -a -m $nextVersion");
        //shell_exec("git commit --allow-empty -m  ' ({$type}): {$commitMessage}");
    }

    protected function getLatestVersion()
    {
        $lastTag = \shell_exec("git for-each-ref refs/tags --sort=-taggerdate --format='%(refname)' --count=1");
        $unprocessedTag = \explode('/', $lastTag);
        $latestVersion = \array_pop($unprocessedTag);

        return explode('.', str_replace('v', '', $latestVersion));
    }

    protected function getNextVersion($type)
    {
        [$major, $minor, $patch] = $this->getLatestVersion();

        if ($type == 'major') {
            $nextVersion = ((int) $major + 1) . '.0.0';
        } else if ($type == 'minor') {
            $nextVersion = $major . '.' . ((int) $minor + 1) . '.0';
        } else {
            $nextVersion = $major . '.' . $minor . '.' . ((int) $patch + 1);
        }
        return "v$nextVersion";
    }

}
