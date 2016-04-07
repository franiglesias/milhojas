<?php

namespace Tests\Library\EventSourcing;

use Milhojas\Library\EventSourcing\EventStream\EventStream;
use Milhojas\Library\EventBus\Event;

use Tests\Library\EventSourcing\EventStore\Fixtures\EventDouble;


class EventStreamTest extends \PHPUnit_Framework_Testcase {
	
	public function test_event_stream()
	{
		$events = array(
			new EventDouble('Event 1'),
			new EventDouble('Event 2'),
			new EventDouble('Event 3'),
		);
		$Stream = new EventStream($events);
		foreach ($Stream as $event) {
			$this->assertEquals(current($events), $event);
			next($events);
		}
	}
	
	public function test_it_can_return_the_number_of_events_it_holds()
	{
		$events = array(
			new EventDouble('Event 1'),
			new EventDouble('Event 2'),
			new EventDouble('Event 3'),
		);
		$Stream = new EventStream($events);
		$this->assertEquals(3, $Stream->count());
	}
	
	public function test_it_can_flush_events()
	{
		$events = array(
			new EventDouble('Event 1'),
			new EventDouble('Event 2'),
			new EventDouble('Event 3'),
		);
		$Stream = new EventStream($events);
		$Stream->flush();
		$this->assertEquals(0, $Stream->count());
	}
	
	public function test_it_can_record_events()
	{
		$Stream = new EventStream(array());
		$Stream->recordThat(new EventDouble('event 1'));
		$this->assertEquals(1, $Stream->count());
		$Stream->recordThat(new EventDouble('event 2'));
		$this->assertEquals(2, $Stream->count());
		$Stream->recordThat(new EventDouble('event 3'));
		$this->assertEquals(3, $Stream->count());
	}
	
	public function test_it_can_create_empty_event_stream()
	{
		$Stream = new EventStream();
		$this->assertEquals(0, $Stream->count());
	}
	
	public function test_it_can_create_empty_event_stream_with_empty_array()
	{
		$Stream = new EventStream(array());
		$this->assertEquals(0, $Stream->count());
	}
	
}

?>