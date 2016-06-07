<?php


namespace Tests\Library\EventSourcing;

use Milhojas\Library\EventSourcing\EventStream\EventMessage;

use Milhojas\Library\EventSourcing\Domain\Event;
use Milhojas\Library\EventSourcing\DTO\EntityDTO;
use Milhojas\Library\ValueObjects\Identity\Id;
use Tests\Library\EventSourcing\EventStore\Fixtures\EventDouble;

/**
* Description
*/
class EventMessageTest extends \PHPUnit_Framework_TestCase
{
	
	public function test_it_creates_an_event_message()
	{
		$message = EventMessage::record(new EventDouble(1), new EntityDTO('Entity', new Id(1), 1));
		$this->assertEquals('Tests\Library\EventSourcing\EventStore\Fixtures\EventDouble with Entity:1:1', (string)$message);
	}
	
	public function test_it_can_return_the_event()
	{
		$message = EventMessage::record(new EventDouble(1), new EntityDTO('Entity', new Id(1), 1));
		$this->assertEquals(new EventDouble(1), $message->getEvent());
	}
	
	public function test_it_can_add_metadata()
	{
		$message = EventMessage::record(new EventDouble(1), new EntityDTO('Entity', new Id(1), 1));
		$message->addMetadata('Meta', 'Data');
		$this->assertEquals(array('Meta' => 'Data'), $message->getMetadata());
	}
	
	public function test_it_can_add_an_array_of_metadata()
	{
		$message = EventMessage::record(new EventDouble(1), new EntityDTO('Entity', new Id(1), 1));
		$metadata = array(
			'meta' => 'data',
			'field' => 'value'
		);
		$message->addMetadata($metadata);
		$this->assertEquals($metadata, $message->getMetadata());
	}
	
}

?>