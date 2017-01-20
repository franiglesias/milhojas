<?php

namespace spec\Milhojas\Application\Management\Listener;

use Milhojas\Application\Management\Event\PayrollCouldNotBeFound;
use Milhojas\Application\Management\Listener\RegisterEmployeeNoPayroll;
use Milhojas\Domain\Management\Employee;
use Milhojas\Messaging\EventBus\Listener;
use org\bovigo\vfs\vfsStream;
use PhpSpec\ObjectBehavior;

class RegisterEmployeeNoPayrollSpec extends ObjectBehavior
{
    public function let()
    {
        $file = $this->createFile();
        $this->beConstructedWith($file);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(RegisterEmployeeNoPayroll::class);
        $this->shouldImplement(Listener::class);
    }

    public function it_handles_PayrollCouldNotBeFound_event(PayrollCouldNotBeFound $event, Employee $employee)
    {
        $employee->getFullName()->shouldBeCalled()->willReturn('María Ramos');
        $event->getEmployee()->shouldBeCalled()->willReturn($employee);
        $this->handle($event);
    }

    public function it_handles_several_PayrollCouldNotBeFound_events(PayrollCouldNotBeFound $event, Employee $employee, PayrollCouldNotBeFound $event2, Employee $employee2)
    {
        $employee->getFullName()->shouldBeCalled()->willReturn('María Ramos');
        $event->getEmployee()->shouldBeCalled()->willReturn($employee);
        $employee2->getFullName()->shouldBeCalled()->willReturn('Pedro Pérez');
        $event2->getEmployee()->shouldBeCalled()->willReturn($employee2);
        $this->handle($event);
        $this->handle($event2);
    }

    private function createFile()
    {
        $fs = vfsStream::setup('root', 0, []);

        $file = vfsStream::newFile('no-payroll-found.data')
             ->at($fs);

        return $file->url();
    }
}
