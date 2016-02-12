<?php


namespace Tests\Library\EventSourcing;

use Milhojas\Library\EventSourcing\EventMessage;

use Milhojas\Library\EventSourcing\Domain\DomainEvent;
use Milhojas\Library\EventSourcing\DTO\EntityData;
/**
* Description
*/
class EventMessageTest extends \PHPUnit_Framework_TestCase
{
	
	function test_it_creates_an_event_message()
	{
		// $event = $this->getMockBuilder('Milhojas\Library\EventSourcing\Domain\DomainEvent')
		// 	->disableOriginalConstructor()
		//             ->getMock();
		// $entity = $this->getMockBuilder('Milhojas\Library\EventSourcing\DTO\EntityData')
		// 	->getMock();
		// $Message = EventMessage::record($event, $entity);
		// $this->assertInstanceOf('Milhojas\Library\EventSourcing\EventMessage', $Message);
	}
	
	public function test_it_can_return_the_event()
	{
		// $event = $this->getMockBuilder('Milhojas\Library\EventSourcing\Domain\DomainEvent')
		// 	->disableOriginalConstructor()
		//             ->getMock();
		// $entity = $this->getMockBuilder('Milhojas\Library\EventSourcing\Domain\EventSourced')
		// 	->getMock();
		// $Message = EventMessage::record($event, $entity);
		// $this->assertEquals($event, $Message->getEvent());
	}
	
	public function test_it_can_add_metadata()
	{
		// $event = $this->getMockBuilder('Milhojas\Library\EventSourcing\Domain\DomainEvent')
		// 	->disableOriginalConstructor()
		//             ->getMock();
		// $entity = $this->getMockBuilder('Milhojas\Library\EventSourcing\Domain\EventSourced')
		// 	->getMock();
		// $Message = EventMessage::record($event, $entity);
		// $Message->addMetaData('data', 'some data');
		// $this->assertEquals(array('data' => 'some data'), $Message->getMetaData());
	}
	
	public function test_it_can_add_an_array_of_metadata()
	{
		// $event = $this->getMockBuilder('Milhojas\Library\EventSourcing\Domain\DomainEvent')
		// 	->disableOriginalConstructor()
		//             ->getMock();
		// $entity = $this->getMockBuilder('Milhojas\Library\EventSourcing\Domain\EventSourced')
		// 	->getMock();
		// $meta = array('data' => 'some data', 'data 2' => 'some data');
		// $Message = EventMessage::record($event, $entity);
		// $Message->addMetaData($meta);
		// $this->assertEquals($meta, $Message->getMetaData());
	}
	
}

?>