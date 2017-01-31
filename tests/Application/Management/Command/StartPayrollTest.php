<?php

use Milhojas\Messaging\CommandBus\CommandBus;
use Milhojas\Messaging\CommandBus\Worker\ExecuteWorker;
use Milhojas\Messaging\Shared\Pipeline\WorkerPipeline;
use Milhojas\Messaging\Shared\Worker\LoggerWorker;
use Milhojas\Messaging\Shared\Worker\DispatchEventsWorker;
use Milhojas\Messaging\Shared\Loader\TestLoader;
use Milhojas\Messaging\Shared\Inflector\Inflector;
use Milhojas\Messaging\EventBus\EventBus;
use Milhojas\Messaging\EventBus\Worker\DispatcherWorker;
use Milhojas\Messaging\EventBus\EventRecorder;
use Milhojas\Application\Management\Command\EndPayroll;
use Milhojas\Application\Management\Command\StartPayroll;
use Milhojas\Application\Management\Command\EndPayrollHandler;
use Milhojas\Application\Management\Command\StartPayrollHandler;
use Milhojas\Application\Management\PayrollProgressExchange;
use Milhojas\Domain\Management\PayrollMonth;
use Milhojas\Domain\Management\PayrollReporter;
use Psr\Log\LoggerInterface;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\NullAdapter;

class StartPayrollTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $loader = new TestLoader();
        $recorder = new EventRecorder();
        $filesystem = new Filesystem(new NullAdapter());
        $exchanger = new PayrollProgressExchange('exchange-file.json', $filesystem);
        $loader->add('management.start_payroll.handler', new StartPayrollHandler($exchanger, $recorder));
        $loader->add('management.end_payroll.handler', new EndPayrollHandler($recorder));
        $inflector = $this->prophesize(Inflector::class);
        $inflector->inflect(StartPayroll::class)->willReturn('management.start_payroll.handler');
        $inflector->inflect('management.payroll_distribution_started.event')->willReturn([]);
        $inflector->inflect(EndPayroll::class)->willReturn('management.end_payroll.handler');
        $inflector->inflect('management.all_payrolls_were_sent.event')->willReturn([]);
        $logger = $this->prophesize(LoggerInterface::class);
        $eventBus = new EventBus(new DispatcherWorker($inflector->reveal(), $loader));

        $workers = [
            new ExecuteWorker($loader, $inflector->reveal()),
            new LoggerWorker($logger->reveal()),
            new DispatchEventsWorker($eventBus, $recorder),
        ];
        $pipeline = new WorkerPipeline($workers);
        $this->bus = new CommandBus($pipeline);
    }

    public function test_it_sends_start_payroll_command()
    {
        $this->bus->execute(new StartPayroll(new PayrollReporter(10, 100)));
        $this->bus->execute(new EndPayroll(new PayrollMonth('01', '2017'), new PayrollReporter(10, 100)));
    }
}
