<?php

namespace Tests\Library\CommandBus\Workers;

use Milhojas\Library\CommandBus\Workers\DispatchEventsWorker;
use Milhojas\Library\EventBus\EventBus;
use Milhojas\Library\EventBus\SimpleEventBus;
use Milhojas\Library\EventBus\EventRecorder;

# Doubles and Fixtures

use Tests\Library\CommandBus\Fixtures\SimpleCommand;
use Tests\Library\EventBus\Utils\EventBusSpy;

use Tests\Library\EventBus\Fixtures\TestEvent;
use Tests\Library\EventBus\Fixtures\IgnoredEvent;
use Tests\Library\EventBus\Fixtures\SimpleEvent;
use Tests\Library\EventBus\Fixtures\TestEventHandler;
use Tests\Library\EventBus\Fixtures\SimpleEventHandler;

use Monolog\Logger;

class DispatchEventsWorkerTest extends \PHPUnit_Framework_Testcase {
	
	public function test__DispatchEventsWorker()
	{
		$bus = new EventBusSpy(new SimpleEventBus(new Logger('Test')));
		$bus->addHandler('test.event', new TestEventHandler($bus));
		
		$this->assertTrue($bus->assertWasRegistered('test.event', new TestEventHandler($bus)));
		
		$recorder = new EventRecorder();
		$recorder->recordThat(new TestEvent('data'));
		
		$worker = new DispatchEventsWorker($bus, $recorder);
		$worker->execute(new SimpleCommand('Example'));
		
		$this->assertTrue($bus->eventWasHandled('test.event'));
	}
}
?>
