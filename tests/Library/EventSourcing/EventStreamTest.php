<?php

namespace Tests\Library\EventSourcing;

use Milhojas\Library\EventSourcing\EventStream;
use Milhojas\Library\EventSourcing\DomainEvent;

class EventStreamTest extends \PHPUnit_Framework_Testcase {
	
	public function test_event_stream()
	{
		$events = array(
			'Event 1',
			'Event 2',
			'Event 3'
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
			'Event 1',
			'Event 2',
			'Event 3'
		);
		$Stream = new EventStream($events);
		$this->assertEquals(3, $Stream->count());
	}
	
	public function test_it_can_flush_events()
	{
		$events = array(
			'Event 1',
			'Event 2',
			'Event 3'
		);
		$Stream = new EventStream($events);
		$Stream->flush();
		$this->assertEquals(0, $Stream->count());
	}
	
	public function test_it_can_append_events()
	{
		$Stream = new EventStream(array());
		$Stream->append('event 1');
		$this->assertEquals(1, $Stream->count());
		$Stream->append('event 2');
		$this->assertEquals(2, $Stream->count());
		$Stream->append('event 3');
		$this->assertEquals(3, $Stream->count());
	}
	
	public function test_it_can_create_empty_event_stream()
	{
		$Stream = new EventStream();
		$this->assertEquals(0, $Stream->count());
	}
}

?>