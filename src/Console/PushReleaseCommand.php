<?php namespace Nerdial\Standards\Console;

use Nerdial\Standards\Generator\ChangelogGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PushReleaseCommand extends Command
{

    protected static $defaultName = 'push:release';
    protected $releaseApi = 'https://api.github.com/repos/nerdial/testing-tags/releases';

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
            ->setHelp('')
            ->setDefinition(
                new InputDefinition([
                    new InputOption('token', 't', InputOption::VALUE_REQUIRED, 'Github personal token in order to communicate to github api'),
                ])
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = new \GuzzleHttp\Client();
        $tokenOption = $input->getOption('token');
        if (isset($_ENV['GITHUB_TOKEN_API']) and !empty($tokenOption)) {
            $apiToken = $_ENV['GITHUB_TOKEN_API'];
        } else if (isset($tokenOption) and !empty($tokenOption)) {
            $apiToken = $tokenOption;
        } else {
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