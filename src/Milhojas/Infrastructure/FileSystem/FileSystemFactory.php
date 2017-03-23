<?php
/**
 * Created by PhpStorm.
 * User: miralba
 * Date: 23/3/17
 * Time: 11:25
 */

namespace Milhojas\Infrastructure\FileSystem;


use League\Flysystem\Filesystem;
use League\Flysystem\ZipArchive\ZipArchiveAdapter;


/**
 * Utility to create FileSystems on the fly
 * Class FileSystemFactory
 * @package Milhojas\Infrastructure\FileSystem
 */
class FileSystemFactory
{
    /**
     * Creates a zip filesystem from the archive passed
     *
     * @param $path string path to the zip archive
     *
     * @return Filesystem
     */
    public function getZip($path)
    {
        return new Filesystem(new ZipArchiveAdapter($path));
    }
}
