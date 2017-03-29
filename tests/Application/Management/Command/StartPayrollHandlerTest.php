<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 29/3/17
 * Time: 13:32
 */

namespace Tests\Application\Management\Command;

use Milhojas\Application\Management\Command\StartPayroll;
use Milhojas\Application\Management\Command\StartPayrollHandler;
use Milhojas\Application\Management\Event\PayrollDistributionStarted;
use Milhojas\Application\Management\PayrollProgressExchange;
use Milhojas\Domain\Management\PayrollReporter;
use Milhojas\Messaging\EventBus\EventBus;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;


class StartPayrollHandlerTest extends TestCase
{

    public function test_it_handles_the_command()
    {
        $command = $this->getCommand();
        $exchanger = $this->prophesize(PayrollProgressExchange::class);
        $exchanger->init()->shouldBeCalled();
        $dispatcher = $this->prophesize(EventBus::class);
        $dispatcher->dispatch(Argument::type(PayrollDistributionStarted::class))->shouldBeCalled();
        $handler = new StartPayrollHandler($exchanger->reveal(), $dispatcher->reveal());
        $handler->handle($command);
    }

    protected function getCommand()
    {
        $command = new StartPayroll(new PayrollReporter(1, 100));

        return $command;
    }
}
