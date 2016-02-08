<?php

namespace Tests\Library\EventSourcing\EventStore;

use Milhojas\Library\EventSourcing\EventStore\EventBuilder;
use Milhojas\Library\EventSourcing\EventStore\Event;
use Milhojas\Library\EventSourcing\EventMessage;

/**
* Description
*/
class EventBuilderTest extends \PHPUnit_Framework_TestCase
{

	public function test_it_builds_a_event_doctrine_entity()
	{
		// $event = $this->getMockBuilder('\Milhojas\Library\EventSourcing\DomainEvent')->getMock();
		// $entity = $this->getMockBuilder('\Milhojas\Library\EventSourcing\EventSourced')->getMock();
		// $builder = new EventBuilder();
		// $message = EventMessage::record($event, $entity);
		// $event = $builder->build($message);
		// $expected = new Event();
		// $this->assertEquals($expected, $event);
	}
}

?>