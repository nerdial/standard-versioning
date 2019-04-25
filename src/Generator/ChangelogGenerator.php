<?php namespace Nerdial\Standards\Generator;

class ChangelogGenerator
{

    public static function generateChanglogFile()
    {
        $output = self::getOutput();
        \file_put_contents('CHANGELOG.md', $output);
    }

    public function getOutput()
    {
        $allTags = self::getAllTags();
        return self::generateCreatedOutput($allTags);
    }

    protected static function generateCreatedOutput($tags)
    {
        $changelogData = '';
        foreach ($tags as $tag) {
            $nextItem = next($tags);
            $currentTag = $tag['tag'];
            $nextTag = $nextItem['tag'];
            $commits = self::getCommitsBetween($currentTag, $nextTag);
            $changelogData .= self::generateChangelog($tag, $commits);
        }
        return $changelogData;
    }

    protected static function getAllTags()
    {
        $extractedTags = \shell_exec("git tag --sort=-creatordate --format '%(tag) %(taggerdate:format-local:%Y-%m-%d)' ");
        $allTags = \array_filter(explode(PHP_EOL, $extractedTags));
        array_pop($allTags);

        return \array_map(function ($value) {
            $value = explode(' ', $value);
            return ['tag' => $value[0], 'date' => $value[1]];
        }, $allTags);
    }

    protected static function generateChangelog($tag, $commits)
    {

        $commits = \array_filter(explode(PHP_EOL, $commits));
        $commitString = "";
        if (\is_array($commits)) {
            foreach ($commits as $commit) {
                $commitString .= "* " . $commit . PHP_EOL;
            }
        }
        return "## {$tag['tag']} ({$tag['date']}) " . PHP_EOL . "{$commitString} ";
    }

    protected static function getCommitsBetween($nextTag, $previousTag)
    {
        return \shell_exec("git log --pretty=oneline --pretty=format:'%s' $nextTag...$previousTag");
    }
}
