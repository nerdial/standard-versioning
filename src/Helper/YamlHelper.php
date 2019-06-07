<?php namespace Nerdial\Standards\Helper;

use Symfony\Component\Yaml\Yaml;

class YamlHelper
{
    const CONFIG_NAME='moon.yaml';
    public static function createConfigFile(string $tagFormat)
    {
        $array = [
            'tag_format' => $tagFormat,
        ];
        
        $yaml = Yaml::dump($array);
        
        return \file_put_contents(static::CONFIG_NAME, $yaml);
    }

    public static function fileExists()
    {
        return \file_exists(static::CONFIG_NAME) ? true : false;
    }
}
