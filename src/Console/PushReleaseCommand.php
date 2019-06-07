<?php namespace Nerdial\Standards\Console;

use Nerdial\Standards\Generator\ChangelogGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Nerdial\Standards\Helper\GitHelper;

class PushReleaseCommand extends Command
{

    protected static $defaultName = 'release';
    protected $releaseApi = 'https://api.github.com/repos/nerdial/testing-tags/releases';

    public function __construct()
    {
        parent::__construct();
    }
    protected function configure()
    {
        $this
        // the short description shown while running "php bin/console list"
        ->setDescription('Create a new github release, find newest tag with commit messages and push it to github repository')

        // the full command description shown when running the command with
        // the "--help" option
            ->setHelp('')
            ->setDefinition(
                new InputDefinition([
                    new InputOption('token', 't', InputOption::VALUE_REQUIRED, 'Github personal token in order to communicate to github api'),
                ])
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        if (!GitHelper::gitDirectoryExists()) {
            $output->writeln('<error>  Make sure current direcory is a git repository by calling <question> git init </question> </error>');
            return 1; // non-zero code - fails
        }


        $client = new \GuzzleHttp\Client();
        $tokenOption = $input->getOption('token');

        $apiToken = $_ENV['GITHUB_TOKEN_API'] ?? $tokenOption ?? null;

        if (!isset($apiToken) || empty($apiToken) ) {
            throw new \Exception('You need to either define an environment variable called GITHUB_TOKEN_API or pass option -t, if you want to use this api');
        }

        $output = ChangelogGenerator::getOutput();

        $response = $client->request('POST', $this->releaseApi, [
            'headers' => [
                'Authorization' => ' token ' . $apiToken,
            ],
            'json' => [
                "tag_name" => 'v1.0.4',
                "target_commitish" => "master",
                "name" => 'v1.0.4',
                "body" => $output,
                "draft" => false,
                "prerelease" => false,
            ],
        ]);
    }

}
