<?php

namespace spec\Milhojas\Application\Management\Listener;

use League\Flysystem\FilesystemInterface;
use Milhojas\Application\Management\Event\PayrollEmailWasSent;
use Milhojas\Application\Management\Listener\ArchiveSentPayrolls;
use Milhojas\Domain\Management\Employee;
use Milhojas\Domain\Management\PayrollMonth;
use Milhojas\Domain\Management\Payrolls;
use Milhojas\Messaging\EventBus\Listener;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;


class ArchiveSentPayrollsSpec extends ObjectBehavior
{
    public function let(Payrolls $payrolls, FilesystemInterface $filesystem)
    {
        $this->beConstructedWith($payrolls, $filesystem);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(ArchiveSentPayrolls::class);
        $this->shouldImplement(Listener::class);
    }

    public function it_deletes_employee_files_to_an_archive_location(PayrollEmailWasSent $event, Employee $employee, Payrolls $payrolls, PayrollMonth $month, \SplFileInfo $file)
    {
        $event->getEmployee()->shouldBeCalled()->willReturn($employee);
        $event->getMonth()->shouldBeCalled()->willReturn($month);
        $event->getRepositories()->shouldBeCalled()->willReturn(['path1', 'path2']);
        $payrolls->getForEmployee($employee, $month, ['path1', 'path2'])->willReturn($file);
        $this->handle($event);
    }
}
