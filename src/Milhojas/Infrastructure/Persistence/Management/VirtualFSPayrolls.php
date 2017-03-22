<?php

namespace Milhojas\Infrastructure\Persistence\Management;

use League\Flysystem\FilesystemInterface;
use League\Flysystem\MountManager;
use Milhojas\Domain\Management\Employee;
use Milhojas\Domain\Management\PayrollMonth;
use Milhojas\Domain\Management\Payrolls;
use Milhojas\Infrastructure\Persistence\Management\Exceptions\EmployeeHasNoPayrollFiles;


/**
 * Class VirtualFSPayrolls
 *
 * Uses a FlySystem VirtualFS to retrieve data
 * @package Milhojas\Infrastructure\Persistence\Management
 */
class VirtualFSPayrolls implements Payrolls
{
    /**
     * Destination filesystem
     * @var FilesystemInterface
     */
    private $filesystem;
    /**
     * @var MountManager
     */
    private $manager;

    /**
     * VirtualFSPayrolls constructor.
     *
     * @param FilesystemInterface $filesystem
     */
    public function __construct(FilesystemInterface $filesystem, MountManager $manager)
    {
        $this->filesystem = $filesystem;
        $this->manager = $manager;
        $this->manager->mountFilesystem('local', $filesystem);
    }

    /**
     * @param Employee     $employee
     * @param PayrollMonth $month
     * @param              $repositories
     *
     * @return mixed
     */
    public function getForEmployee(Employee $employee, PayrollMonth $month, $repositories = null)
    {
        $files = $this->filesystem->listContents('new', true);
        $pattern = sprintf('/_trabajador_(%s)_/', implode('|', $employee->getPayrolls()));

        $found = array_reduce(
            $files,
            function ($carry, $file) use ($pattern) {
                if (preg_match($pattern, $file['path'])) {
                    $carry[] = $file['path'];
                }

                return $carry;
            }
        );

        if ($found) {
            return $found;
        }

        throw new EmployeeHasNoPayrollFiles(sprintf('No payroll files for %s', $employee->getFullName()));

    }

    public function loadArchive(PayrollMonth $month, FilesystemInterface $zip)
    {
        $this->manager->mountFilesystem('zip', $zip);
        $files = $this->manager->listContents('zip://', true);
        foreach ($files as $file) {
            $destination = sprintf('new/%s/%s', $month->getFolderName(), $file['path']);
            $this->manager->move('zip://'.$file['path'], 'local://'.$destination);
        }
    }

    public function getAttachments(Employee $employee, PayrollMonth $month)
    {
        $attachments = [];
        $files = $this->getForEmployee($employee, $month);
        foreach ($files as $file) {
            $attachments[] = [
                'data' => $this->filesystem->read($file),
                'type' => $this->filesystem->getMimetype($file),
                'filename' => basename($file)
            ];
        }
        return $attachments;
    }



    public function archive(Employee $employee, PayrollMonth $month)
    {
        $files = $this->getForEmployee($employee, $month);
        foreach ($files as $file) {
            $destination = str_replace('new/', 'archive/', $file);
            $this->filesystem->rename($file, $destination);
        }
    }


}

