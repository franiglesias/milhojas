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
}

?>