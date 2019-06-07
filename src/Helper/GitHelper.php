<?php namespace Nerdial\Standards\Helper;

class GitHelper
{
    const GIT_DIRECTORY='./.git';
    

    public static function gitDirectoryExists()
    {
        return \file_exists(static::GIT_DIRECTORY) ? true : false;
    }
}
