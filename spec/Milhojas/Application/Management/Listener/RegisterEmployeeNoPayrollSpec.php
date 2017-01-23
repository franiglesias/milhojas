<?php

namespace spec\Milhojas\Application\Management\Listener;

use League\Flysystem\FilesystemInterface;
use Milhojas\Application\Management\Event\PayrollCouldNotBeFound;
use Milhojas\Application\Management\Listener\RegisterEmployeeNoPayroll;
use Milhojas\Domain\Management\Employee;
use Milhojas\Messaging\EventBus\Listener;
use PhpSpec\ObjectBehavior;

class RegisterEmployeeNoPayrollSpec extends ObjectBehavior
{
    public function let(FilesystemInterface $filesystem)
    {
        $this->beConstructedWith('no-payroll-found.data', $filesystem);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(RegisterEmployeeNoPayroll::class);
        $this->shouldImplement(Listener::class);
    }

    public function it_handles_PayrollCouldNotBeFound_event(PayrollCouldNotBeFound $event, Employee $employee, $filesystem)
    {
        $employee->getFullName()->shouldBeCalled()->willReturn('María Ramos');
        $event->getEmployee()->shouldBeCalled()->willReturn($employee);
        $filesystem->has('no-payroll-found.data')->shouldBeCalled()->willReturn(true);
        $filesystem->read('no-payroll-found.data')->willReturn('');
        $filesystem->put('no-payroll-found.data', 'María Ramos'.PHP_EOL)->shouldBeCalled();
        $this->handle($event);
    }

    public function it_creates_file_when_needed(PayrollCouldNotBeFound $event, Employee $employee, $filesystem)
    {
        $employee->getFullName()->shouldBeCalled()->willReturn('María Ramos');
        $event->getEmployee()->shouldBeCalled()->willReturn($employee);
        $filesystem->has('no-payroll-found.data')->shouldBeCalled()->willReturn(false);
        $filesystem->put('no-payroll-found.data', 'María Ramos'.PHP_EOL)->shouldBeCalled();
        $this->handle($event);
    }

    public function it_appends_data(PayrollCouldNotBeFound $event, Employee $employee, $filesystem)
    {
        $employee->getFullName()->shouldBeCalled()->willReturn('María Ramos');
        $event->getEmployee()->shouldBeCalled()->willReturn($employee);
        $filesystem->has('no-payroll-found.data')->shouldBeCalled()->willReturn(true);
        $filesystem->read('no-payroll-found.data')->willReturn('Pedro Pérez'.PHP_EOL);
        $filesystem->put('no-payroll-found.data', 'Pedro Pérez'.PHP_EOL.'María Ramos'.PHP_EOL)->shouldBeCalled();
        $this->handle($event);
    }
}
