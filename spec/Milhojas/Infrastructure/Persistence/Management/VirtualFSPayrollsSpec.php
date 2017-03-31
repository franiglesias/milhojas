<?php

namespace spec\Milhojas\Infrastructure\Persistence\Management;

use League\Flysystem\FilesystemInterface;
use League\Flysystem\MountManager;
use Milhojas\Domain\Management\Employee;
use Milhojas\Domain\Management\PayrollDocument;
use Milhojas\Domain\Management\PayrollMonth;
use Milhojas\Domain\Management\Payrolls;
use Milhojas\Infrastructure\FileSystem\FileSystemFactory;
use Milhojas\Infrastructure\Persistence\Management\VirtualFSPayrolls;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;


class VirtualFSPayrollsSpec extends ObjectBehavior
{
    protected $sample1 = [
        'basename' => 'archivo_trabajador_123456_masinfo.pdf',
        'path'     => 'archivo_trabajador_123456_masinfo.pdf',
    ];

    protected $sample2 = [
        'basename' => 'archivo_trabajador_789012_masinfo.pdf',
        'path'     => 'archivo_trabajador_789012_masinfo.pdf',
    ];

    public function let(FilesystemInterface $filesystem, MountManager $manager, FileSystemFactory $factory)
    {
        $this->beConstructedWith($filesystem, $manager, $factory);
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
        FilesystemInterface $filesystem,
        FileSystemFactory $factory
    ) {
        $factory->getZip(Argument::type('string'))->willReturn($zip);
        $manager->mountFilesystem('local', $filesystem)->shouldBeCalled();
        $manager->mountFilesystem('zip', $zip)->shouldBeCalled();

        $manager->listContents('zip://', true)->shouldBeCalled()->willReturn(
            [
                $this->sample1,
                $this->sample2,
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


        $this->loadMonthDataFrom($month, ['path/to/zip.zip']);
    }

    function it_loads_from_zip_archive_encapsulated(
        PayrollMonth $month,
        FilesystemInterface $zip,
        MountManager $manager,
        FilesystemInterface $filesystem,
        FileSystemFactory $factory
    ) {
        $manager->mountFilesystem('local', $filesystem)->shouldBeCalled();
        $manager->mountFilesystem('zip', $zip)->shouldBeCalled();

        $manager->listContents('zip://', true)->shouldBeCalled()->willReturn(
            [
                $this->sample1,
                $this->sample2,
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

        $factory->getZip('var/inbox/some/path.zip')->shouldBeCalled()->willReturn($zip);

        $this->loadMonthDataFrom($month, ['some/path.zip']);
    }



    public function it_retrieves_files_for_an_employee(
        Employee $employee,
        PayrollMonth $month,
        FilesystemInterface $filesystem
    ) {
        $filesystem->listContents('new', true)->shouldBeCalled()->willReturn(
            [
                $this->sample1,
                $this->sample2,
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
                $this->sample1,
                $this->sample2,
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
                $this->sample1,
                $this->sample2,
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
                PayrollDocument::inline(
                    'archivo_trabajador_123456_masinfo.pdf',
                    'application/pdf',
                    'content of the file'
                ),
            ]
        )
        ;
    }

    public function it_archives_distributed_payrolls(
        Employee $employee,
        PayrollMonth $month,
        FilesystemInterface $filesystem,
        FileSystemFactory $factory
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


}
