<?php

namespace spec\Milhojas\Infrastructure\Persistence\Management;

use League\Flysystem\FilesystemInterface;
use Milhojas\Domain\Management\Employee;
use Milhojas\Domain\Management\PayrollMonth;
use Milhojas\Domain\Management\Payrolls;
use Milhojas\Infrastructure\Persistence\Management\VirtualFSPayrolls;
use PhpSpec\ObjectBehavior;


class VirtualFSPayrollsSpec extends ObjectBehavior
{
    public function let(FilesystemInterface $filesystem)
    {
        $this->beConstructedWith($filesystem);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(VirtualFSPayrolls::class);
        $this->shouldImplement(Payrolls::class);
    }

    public function it_retrieves_files_for_an_employee(
        Employee $employee,
        PayrollMonth $month,
        FilesystemInterface $filesystem
    ) {
        $filesystem->listContents('')->shouldBeCalled()->willReturn(
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
        $this->getForEmployee($employee, $month, [''])->shouldBe(
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
        $filesystem->listContents('')->shouldBeCalled()->willReturn(
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
        $this->getForEmployee($employee, $month, [''])->shouldBe(
            [
                'archivo_trabajador_123456_masinfo.pdf',
                'archivo_trabajador_123456_otro_archivo.pdf',
            ]
        )
        ;
    }

    public function it_retrieves_files_for_an_employee_from_serveral_locations(
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
