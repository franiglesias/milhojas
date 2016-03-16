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
	
	function __construct()
	{
	}
	
	public function handle(Event $event)
	{
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
		$bus->addHandler('test.event', new TestEventHandler());
		$this->assertTrue($bus->assertWasRegistered('test.event', new TestEventHandler()));
	}
	
	public function test_it_can_handle_an_event_to_handlers()
	{
		$bus = new EventBusSpy(new SimpleEventBus());
		$bus->addHandler('test.event', new TestEventHandler());
		$bus->handle(new TestEvent('data'));
	}
}

?>