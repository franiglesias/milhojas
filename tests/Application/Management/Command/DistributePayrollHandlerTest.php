<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 29/3/17
 * Time: 19:04
 */

namespace Tests\Application\Management\Command;

use Milhojas\Application\Management\Command\DistributePayroll;
use Milhojas\Application\Management\Command\DistributePayrollHandler;
use Milhojas\Application\Management\Command\SendPayroll;
use Milhojas\Application\Management\Event\AllPayrollsWereSent;
use Milhojas\Application\Management\Event\PayrollDistributionStarted;
use Milhojas\Domain\Management\Employee;
use Milhojas\Domain\Management\PayrollMonth;
use Milhojas\Domain\Management\Payrolls;
use Milhojas\Domain\Management\Staff;
use Milhojas\Messaging\CommandBus\CommandBus;
use Milhojas\Messaging\EventBus\EventBus;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;


class DistributePayrollHandlerTest extends TestCase
{
    public function test_it_handles_command()
    {
        $command = $this->getCommand();

        $employees = 5;
        $staff = $this->getStaff($employees);

        $payrolls = $this->prophesize(Payrolls::class);
        $payrolls->loadMonthDataFrom(Argument::type(PayrollMonth::class), Argument::type('array'))->shouldBeCalled();

        $bus = $this->prophesize(CommandBus::class);
        $bus->execute(Argument::type(SendPayroll::class))->shouldBeCalled($employees);

        $dispatcher = $this->prophesize(EventBus::class);
        $dispatcher->dispatch(Argument::type(PayrollDistributionStarted::class))->shouldBeCalled();
        $dispatcher->dispatch(Argument::type(AllPayrollsWereSent::class))->shouldBeCalled();

        $handler = new DistributePayrollHandler(
            $staff->reveal(),
            $payrolls->reveal(),
            $bus->reveal(),
            $dispatcher->reveal()
        );
        $handler->handle($command);

    }

    protected function getCommand()
    {
        $command = new DistributePayroll(new PayrollMonth('03', '2017'), ['archive.zip']);

        return $command;
    }

    /**
     * @return \Prophecy\Prophecy\ObjectProphecy
     */
    protected function getStaff($employees = 2)
    {
        $employee = $this->prophesize(Employee::class);

        $staff = $this->prophesize(Staff::class);
        $staff->countAll()->shouldBeCalled()->willReturn($employees);
        $staff->getIterator()->shouldBeCalled($employees)->willReturn(
            new \ArrayIterator(array_fill(0, $employees, $employee->reveal()))
        )
        ;

        return $staff;
    }

}
