<?php namespace Nerdial\Standards\Generator;

class ChangelogGenerator
{

    public static function generateChanglogFile()
    {
        $allTags = self::getAllTags();
        self::analyzeLogs($allTags);
    }

    protected static function analyzeLogs($tags)
    {

        $changelogData = '';
        foreach ($tags as $tag) {
            $nextItem = next($tags);
            $currentTag = $tag['tag'];
            $nextTag = $nextItem['tag'];
            $commits = self::getCommitsBetween($currentTag, $nextTag);
            $changelogData .= self::generateChangelog($tag, $commits);
        }

        \file_put_contents('CHANGELOG.md', $changelogData);
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
        return "## [{$tag['tag']}](compare/) ({$tag['date']})
            {$commits} \n";
    }

    protected static function getCommitsBetween($nextTag, $previousTag)
    {
        return \shell_exec("git log --pretty=oneline  $nextTag...$previousTag");
    }
}
