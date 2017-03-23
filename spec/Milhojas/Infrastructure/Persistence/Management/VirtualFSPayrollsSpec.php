<?php

namespace spec\Milhojas\Infrastructure\Persistence\Management;

use League\Flysystem\FilesystemInterface;
use League\Flysystem\MountManager;
use Milhojas\Domain\Management\Employee;
use Milhojas\Domain\Management\PayrollMonth;
use Milhojas\Domain\Management\Payrolls;
use Milhojas\Infrastructure\Persistence\Management\VirtualFSPayrolls;
use PhpSpec\ObjectBehavior;


class VirtualFSPayrollsSpec extends ObjectBehavior
{
    public function let(FilesystemInterface $filesystem, MountManager $manager)
    {
        $this->beConstructedWith($filesystem, $manager);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(VirtualFSPayrolls::class);
        $this->shouldImplement(Payrolls::class);
    }

    function it_loads_from_zip_archive(
        PayrollMonth $month,
        FilesystemInterface $zip,
        MountManager $manager,
        PayrollMonth $month,
        FilesystemInterface $filesystem
    ) {
        $manager->mountFilesystem('local', $filesystem)->shouldBeCalled();
        $manager->mountFilesystem('zip', $zip)->shouldBeCalled();

        $manager->listContents('zip://', true)->shouldBeCalled()->willReturn(
            [
                [
                    'basename' => 'archivo_trabajador_123456_masinfo.pdf',
                    'path' => 'archivo_trabajador_123456_masinfo.pdf',
                ],
                [
                    'basename' => 'archivo_trabajador_789012_masinfo.pdf',
                    'path' => 'archivo_trabajador_789012_masinfo.pdf',
                ],
            ]
        )
        ;
        $month->getFolderName()->shouldBeCalledTimes(2)->willReturn('2017/03');
        $manager->move(
            'zip://archivo_trabajador_123456_masinfo.pdf',
            'local://new/2017/03/archivo_trabajador_123456_masinfo.pdf'
        )->shouldBeCalled()
        ;
        $manager->move(
            'zip://archivo_trabajador_789012_masinfo.pdf',
            'local://new/2017/03/archivo_trabajador_789012_masinfo.pdf'
        )->shouldBeCalled()
        ;


        $this->loadArchive($month, $zip);


    }

    public function it_retrieves_files_for_an_employee(
        Employee $employee,
        PayrollMonth $month,
        FilesystemInterface $filesystem
    ) {
        $filesystem->listContents('new', true)->shouldBeCalled()->willReturn(
            [
                [
                    'basename' => 'archivo_trabajador_123456_masinfo.pdf',
                    'path' => 'archivo_trabajador_123456_masinfo.pdf',
                ],
                [
                    'basename' => 'archivo_trabajador_789012_masinfo.pdf',
                    'path' => 'archivo_trabajador_789012_masinfo.pdf',
                ],
            ]
        )
        ;
        $employee->getPayrolls()->shouldBeCalled()->willReturn(['123456']);
        $this->getForEmployee($employee, $month)->shouldBe(
            [
                'archivo_trabajador_123456_masinfo.pdf',
            ]
        )
        ;
    }


    public function it_retrieves_several_files_for_an_employee(
        Employee $employee,
        PayrollMonth $month,
        FilesystemInterface $filesystem
    ) {
        $filesystem->listContents('new', true)->shouldBeCalled()->willReturn(
            [
                [
                    'basename' => 'archivo_trabajador_123456_masinfo.pdf',
                    'path' => 'archivo_trabajador_123456_masinfo.pdf',
                ],
                [
                    'basename' => 'archivo_trabajador_789012_masinfo.pdf',
                    'path' => 'archivo_trabajador_789012_masinfo.pdf',
                ],
                [
                    'basename' => 'archivo_trabajador_123456_otro_archivo.pdf',
                    'path' => 'archivo_trabajador_123456_otro_archivo.pdf',
                ],
            ]
        )
        ;
        $employee->getPayrolls()->shouldBeCalled()->willReturn(['123456']);
        $this->getForEmployee($employee, $month)->shouldBe(
            [
                'archivo_trabajador_123456_masinfo.pdf',
                'archivo_trabajador_123456_otro_archivo.pdf',
            ]
        )
        ;
    }

    public function it_can_retrieve_attachments(
        Employee $employee,
        PayrollMonth $month,
        FilesystemInterface $filesystem
    ) {
        $filesystem->listContents('new', true)->shouldBeCalled()->willReturn(
            [
                [
                    'basename' => 'archivo_trabajador_123456_masinfo.pdf',
                    'path' => 'archivo_trabajador_123456_masinfo.pdf',
                ],
                [
                    'basename' => 'archivo_trabajador_789012_masinfo.pdf',
                    'path' => 'archivo_trabajador_789012_masinfo.pdf',
                ],
            ]
        )
        ;
        $employee->getPayrolls()->shouldBeCalled()->willReturn(['123456']);
        $this->getForEmployee($employee, $month)->shouldBe(
            [
                'archivo_trabajador_123456_masinfo.pdf',
            ]
        )
        ;
        $filesystem->read('archivo_trabajador_123456_masinfo.pdf')->willReturn('content of the file');
        $filesystem->getMimetype('archivo_trabajador_123456_masinfo.pdf')->willReturn('application/pdf');


        $this->getAttachments($employee, $month)->shouldBeLike(
            [
                [
                    'data' => 'content of the file',
                    'type' => 'application/pdf',
                    'filename' => 'archivo_trabajador_123456_masinfo.pdf',
                ],
            ]
        )
        ;
    }

    public function it_archives_distributed_payrolls(
        Employee $employee,
        PayrollMonth $month,
        FilesystemInterface $filesystem
    ) {
        $filesystem->listContents('new', true)->shouldBeCalled()->willReturn(
            [
                [
                    'basename' => 'archivo_trabajador_123456_masinfo.pdf',
                    'path' => 'new/2017/03/archivo_trabajador_123456_masinfo.pdf',
                ],
                [
                    'basename' => 'archivo_trabajador_789012_masinfo.pdf',
                    'path' => 'new/2017/03/archivo_trabajador_789012_masinfo.pdf',
                ],
            ]
        )
        ;
        $employee->getPayrolls()->willReturn(['123456']);
        $month->getFolderName()->willReturn('2017/03');
        $filesystem->rename(
            'new/2017/03/archivo_trabajador_123456_masinfo.pdf',
            'archive/2017/03/archivo_trabajador_123456_masinfo.pdf'
        )->shouldBeCalled();
        $this->archive($employee, $month);
    }

    public function no_test_it_retrieves_files_for_an_employee_from_serveral_locations(
        Employee $employee,
        PayrollMonth $month,
        FilesystemInterface $filesystem
    ) {
        $filesystem->listContents('repo1')->shouldBeCalled()->willReturn(
            [
                [
                    'basename' => 'archivo_trabajador_123456_masinfo.pdf',
                    'path' => 'repo1/archivo_trabajador_123456_masinfo.pdf',
                ],
                [
                    'basename' => 'archivo_trabajador_789012_masinfo.pdf',
                    'path' => 'repo1/archivo_trabajador_789012_masinfo.pdf',
                ],
            ]
        )
        ;

        $filesystem->listContents('repo2')->shouldBeCalled()->willReturn(
            [
                [
                    'basename' => 'archivo_trabajador_789012_otro_archivo.pdf',
                    'path' => 'repo2/archivo_trabajador_789012_otro_archivo.pdf',
                ],
                [
                    'basename' => 'archivo_trabajador_123456_otro_archivo.pdf',
                    'path' => 'repo2/archivo_trabajador_123456_otro_archivo.pdf',
                ],
            ]
        )
        ;

        $employee->getPayrolls()->shouldBeCalled()->willReturn(['123456']);
        $this->getForEmployee($employee, $month, ['repo1', 'repo2'])->shouldBe(
            [
                'repo1/archivo_trabajador_123456_masinfo.pdf',
                'repo2/archivo_trabajador_123456_otro_archivo.pdf',
            ]
        )
        ;
    }


}
