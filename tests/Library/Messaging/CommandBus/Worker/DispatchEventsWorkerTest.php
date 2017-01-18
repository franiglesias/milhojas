<?php

namespace Tests\Library\Messaging\CommandBus\Worker;

use Milhojas\Library\Messaging\CommandBus\Worker\DispatchEventsWorker;
use Milhojas\Library\Messaging\EventBus\EventBus;
use Milhojas\Library\Messaging\EventBus\EventRecorder;

// Doubles and Fixtures

use Tests\Library\Messaging\CommandBus\Fixtures\SimpleCommand;
use Tests\Library\Messaging\EventBus\Utils\EventBusSpy;
use Tests\Library\Messaging\EventBus\Fixtures\TestEvent;
use Tests\Library\Messaging\EventBus\Fixtures\TestListener;
use Tests\Utils\DummyLogger;

class DispatchEventsWorkerTest extends \PHPUnit_Framework_Testcase
{
    public function test__DispatchEventsWorker()
    {
        $bus = new EventBusSpy(new EventBus(new DummyLogger('Test')));
        $bus->addListener('test.event', new TestListener($bus));

        $this->assertTrue($bus->assertWasRegistered('test.event', new TestListener($bus)));

        $recorder = new EventRecorder();
        $recorder->recordThat(new TestEvent('data'));

        $worker = new DispatchEventsWorker($bus, $recorder);
        $worker->execute(new SimpleCommand('Example'));

        $this->assertTrue($bus->eventWasHandled('test.event'));
    }
}
