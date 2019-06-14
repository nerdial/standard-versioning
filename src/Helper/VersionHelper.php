<?php namespace Nerdial\Standards\Helper;

class VersionHelper
{

    public static function getNextVersion($type, $prefix = 'v')
    {
        [$major, $minor, $patch] = self::getLatestVersion();

        if ($type == 'major') {
            $nextVersion = ((int)$major + 1) . '.0.0';
        } else if ($type == 'minor') {
            $nextVersion = $major . '.' . ((int)$minor + 1) . '.0';
        } else {
            $nextVersion = $major . '.' . $minor . '.' . ((int)$patch + 1);
        }
        return $prefix. "$nextVersion";
    }

    public static function getLatestVersion()
    {
        $lastTag = \shell_exec("git for-each-ref refs/tags --sort=-taggerdate --format='%(refname)' --count=1");
        $unprocessedTag = \explode('/', $lastTag);
        $latestVersion = \array_pop($unprocessedTag);

        return \explode('.', \str_replace('v', '', $latestVersion));
    }
}
