<?php

namespace Milhojas\Infrastructure\Persistence\Management;

use League\Flysystem\FilesystemInterface;
use Milhojas\Domain\Management\Employee;
use Milhojas\Domain\Management\PayrollMonth;
use Milhojas\Domain\Management\Payrolls;


/**
 * Class VirtualFSPayrolls
 *
 * Uses a FlySystem VirtualFS to retrieve data
 * @package Milhojas\Infrastructure\Persistence\Management
 */
class VirtualFSPayrolls implements Payrolls
{
    /**
     * @var FilesystemInterface
     */
    private $filesystem;

    /**
     * VirtualFSPayrolls constructor.
     *
     * @param FilesystemInterface $filesystem
     */
    public function __construct(FilesystemInterface $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * @param Employee     $employee
     * @param PayrollMonth $month
     * @param              $repositories
     *
     * @return mixed
     */
    public function getForEmployee(Employee $employee, PayrollMonth $month, $repositories)
    {
        $files = [];
        foreach ($repositories as $repository) {
            $files = array_merge($files, $this->filesystem->listContents($repository));
        }
        $pattern = sprintf('/_trabajador_(%s)_/', implode('|', $employee->getPayrolls()));

        return array_reduce(
            $files,
            function ($carry, $file) use ($pattern) {
                if (preg_match($pattern, $file['path'])) {
                    $carry[] = $file['path'];
                }

                return $carry;
            }
        );

    }
}

