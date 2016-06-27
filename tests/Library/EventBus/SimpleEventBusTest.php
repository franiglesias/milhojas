<?php

namespace Tests\Library\EventBus;

use Milhojas\Library\EventBus\SimpleEventBus;

use Milhojas\Library\EventSourcing\Domain\Event;
use Milhojas\Library\EventBus\EventHandler;

use Tests\Library\EventBus\Utils\EventBusSpy;

use Tests\Library\EventBus\Fixtures\TestEvent;
use Tests\Library\EventBus\Fixtures\IgnoredEvent;
use Tests\Library\EventBus\Fixtures\SimpleEvent;
use Tests\Library\EventBus\Fixtures\TestEventHandler;
use Tests\Library\EventBus\Fixtures\SimpleEventHandler;

use Monolog\Logger;
/**
* Description
*/
class SimpleEventBusTest extends \PHPUnit_Framework_Testcase
{
	
	private function getEventBus()
	{
		return new SimpleEventBus(new Logger('Test'));
	}
	
	public function test_it_can_add_Event_Handlers()
	{
		$bus = new EventBusSpy($this->getEventBus());
		$bus->addHandler('test.event', new TestEventHandler($bus));
		$this->assertTrue($bus->assertWasRegistered('test.event', new TestEventHandler($bus)));
	}
	
	public function test_it_can_handle_an_event_to_handlers()
	{
		$bus = new EventBusSpy($this->getEventBus());
		$bus->addHandler('test.event', new TestEventHandler($bus));
		$bus->handle(new TestEvent('data'));
		$expected = array(
			'test.event' => array('TestEventHandler')
		);
		
		$this->assertEquals($expected, $bus->getRecordedHandlers());
	}
	
	public function test_it_silently_ignore_events_not_registered()
	{
		$bus = new EventBusSpy($this->getEventBus());
		$bus->addHandler('test.event', new TestEventHandler($bus));
		$bus->handle(new IgnoredEvent('data'));
		$this->assertFalse($bus->eventWasHandled('ignored.event'));
		
	}
	
	public function test_it_does_not_handle_events_not_passed()
	{
		$bus = new EventBusSpy($this->getEventBus());
		$bus->addHandler('test.event', new TestEventHandler($bus));
		$bus->handle(new TestEvent('data'));
		$this->assertFalse($bus->eventWasHandled('ignored.event'));
		$this->assertTrue($bus->eventWasHandled('test.event'));
	}
	
	public function test_it_handles_several_events_with_different_handlers()
	{
		$bus = new EventBusSpy($this->getEventBus());
		$bus->addHandler('test.event', new TestEventHandler($bus));
		$bus->addHandler('simple.event', new SimpleEventHandler($bus));
		$bus->handle(new TestEvent('data'));
		$bus->handle(new SimpleEvent('other Data'));
		$expected = array(
			'test.event' => array('TestEventHandler'),
			'simple.event' => array('SimpleEventHandler')
		);
		$this->assertEquals($expected, $bus->getRecordedHandlers());

	}
	
	public function test_it_handles_several_events_with_same_handler()
	{
		$bus = new EventBusSpy($this->getEventBus());
		$bus->addHandler('test.event', new TestEventHandler($bus));
		$bus->addHandler('simple.event', new TestEventHandler($bus));
		$bus->handle(new TestEvent('data'));
		$bus->handle(new SimpleEvent('other Data'));
		$expected = array(
			'test.event' => array('TestEventHandler'),
			'simple.event' => array('TestEventHandler')
		);
		$this->assertEquals($expected, $bus->getRecordedHandlers());
	}
	
	public function test_a_handler_can_subscribe_to_several_events()
	{
		$bus = new EventBusSpy($this->getEventBus());
		// $bus->addHandler('test.event', new TestEventHandler($bus));
		// $bus->addHandler('simple.event', new TestEventHandler($bus));
		$bus->subscribeHandler(new TestEventHandler($bus), ['test.event', 'simple.event']);
		$bus->handle(new TestEvent('data'));
		$bus->handle(new SimpleEvent('other Data'));
		$expected = array(
			'test.event' => array('TestEventHandler'),
			'simple.event' => array('TestEventHandler')
		);
		$this->assertEquals($expected, $bus->getRecordedHandlers());
	}
	
	
	
}

?>