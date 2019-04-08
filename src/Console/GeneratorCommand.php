<?php namespace Nerdial\Standards\Console;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
/**
 * Author: Chidume Nnamdi <kurtwanger40@gmail.com>
 */
class GeneratorCommand extends SymfonyCommand
{
    
    protected static $defaultName = 'generate';

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
        ->setHelp('This command allows you to create a changelog file...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
       

        $listOfTags = \array_filter(\explode(\PHP_EOL, \shell_exec("git for-each-ref refs/tags --sort=-taggerdate --format='%(refname)' --count=2")));
        $secondTag = \explode('/', \array_pop($listOfTags) )[2];
        $firstTag = \explode('/' , \array_pop($listOfTags) )[2];


        $result = \shell_exec("git for-each-ref refs/tags --sort=-taggerdate --format='%(refname)' --count=1");

        $latestVersion = \explode('/', $result)[2]; // get last item
       
        $sections = \explode('.', $latestVersion);

        $lastItem = \array_pop($sections);
        $incrementedVersion = (int)$lastItem + 1 ;

        array_push($sections, $incrementedVersion);
        $newVersion = \implode('.', $sections);

        shell_exec("git commit --allow-empty -m  'added new tag  "  . $newVersion. " '   ");

        shell_exec("git tag $newVersion -a -m $newVersion");

    
        $latestCommits = \shell_exec("git log --pretty=oneline  $firstTag...$secondTag");

        \file_put_contents('CHANGELOG.md', $latestCommits);



    }
}