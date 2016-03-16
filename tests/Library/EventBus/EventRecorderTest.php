<?php

namespace Tests\Library\EventBus;

use Milhojas\Library\EventBus\EventRecorder;

use Milhojas\Library\EventBus\Event;

/**
* Description
*/
class SimpleEvent implements Event
{
	private $data;
	function __construct($data)
	{
		$this->data = $data;
	}
}

/**
* Description
*/
class EventRecorderTest extends \PHPUnit_Framework_Testcase
{
	
	function test_event_recorder_can_record_an_event()
	{
		$recorder = new EventRecorder();
		$recorder->recordThat(new SimpleEvent('data'));
		$this->assertEquals(1, iterator_count($recorder));
	}
	
	public function test_it_can_return_stored_events()
	{
		$recorder = new EventRecorder();
		$recorder->recordThat(new SimpleEvent('1'));
		$recorder->recordThat(new SimpleEvent('2'));
		$recorder->recordThat(new SimpleEvent('3'));
		$this->assertEquals(3, iterator_count($recorder));
		$events = $recorder->retrieve();
		$this->assertEquals(3, count($events));

	}
	
	
}


?>