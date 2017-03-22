<?php
/**
 * Created by PhpStorm.
 * User: miralba
 * Date: 22/3/17
 * Time: 10:49
 */

namespace Tests\Infrastructure\Persistence\Management;


use League\Flysystem\Adapter\Local;
use League\Flysystem\MountManager;
use Milhojas\Domain\Management\Employee;
use Milhojas\Domain\Management\PayrollMonth;
use Milhojas\Infrastructure\Persistence\Management\VirtualFSPayrolls;
use League\Flysystem\Filesystem;
use League\Flysystem\ZipArchive\ZipArchiveAdapter;


class VirtualFSPayrollsTest extends \PHPUnit_Framework_TestCase
{

    function test_it_can_use_a_ZIP_file_as_fs()
    {


        $filesystem = new Filesystem(
            new ZipArchiveAdapter('/Library/WebServer/Documents/milhojas/var/inbox/php1ZOZO1.zip')
        );
        $local = new Filesystem(new Local('/Library/WebServer/Documents/milhojas/var/inbox/test'));

        $manager = new MountManager(
            [
                'zip' => $filesystem,
                'local' => $local,
            ]
        );

        $files = $manager->listContents('zip://', true);
        foreach ($files as $file) {

            $destination = 'local://'.$file['path'];
            $manager->Put($destination, $manager->read('zip://'.$file['path']));
        }


    }
}
