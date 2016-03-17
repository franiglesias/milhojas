<?php

namespace Tests\Library\EventBus;

use Milhojas\Library\EventBus\SimpleEventBus;

use Milhojas\Library\EventBus\Event;
use Milhojas\Library\EventBus\EventHandler;

use Tests\Library\EventBus\Utils\EventBusSpy;

/**
* Description
*/
class TestEvent implements Event
{
	private $data;
	
	function __construct($data)
	{
		$this->data = $data;
	}
	
	public function getName()
	{
		return 'test.event';
	}
	
	public function getData()
	{
		return $this->data;
	}
}

/**
* Description
*/
class TestEventHandler implements EventHandler
{
	private $bus;
	function __construct($bus)
	{
		$this->bus = $bus;
	}
	
	public function handle(Event $event)
	{
		$this->bus->recordHandler($event, 'TestEventHandler');
	}
}

/**
* Description
*/
class SimpleEventBusTest extends \PHPUnit_Framework_Testcase
{
	
	public function test_it_can_add_Event_Handlers()
	{
		$bus = new EventBusSpy(new SimpleEventBus());
		$bus->addHandler('test.event', new TestEventHandler($bus));
		$this->assertTrue($bus->assertWasRegistered('test.event', new TestEventHandler($bus)));
	}
	
	public function test_it_can_handle_an_event_to_handlers()
	{
		$bus = new EventBusSpy(new SimpleEventBus());
		$bus->addHandler('test.event', new TestEventHandler($bus));
		$bus->handle(new TestEvent('data'));
		$expected = array(
			'test.event' => array('TestEventHandler')
		);
		
		$this->assertEquals($expected, $bus->getRecordedHandlers());
	}
}

?>