<?php


namespace Tests\Library\EventSourcing;

use Milhojas\Library\EventSourcing\EventMessage;

use Milhojas\Library\EventSourcing\DomainEvent;
/**
* Description
*/
class EventMessageTest extends \PHPUnit_Framework_TestCase
{
	
	function test_it_creates_an_event_message()
	{
		$event = $this->getMockBuilder('Milhojas\Library\EventSourcing\DomainEvent')
			->disableOriginalConstructor()
            ->getMock();
		$Message = EventMessage::record($event, 'Entity', 'entityid');
		$this->assertInstanceOf('Milhojas\Library\EventSourcing\EventMessage', $Message);
	}
	
	public function test_it_can_return_the_event()
	{
		$event = $this->getMockBuilder('Milhojas\Library\EventSourcing\DomainEvent')
			->disableOriginalConstructor()
            ->getMock();
		$Message = EventMessage::record($event, 'Entity', 'entityid');
		$this->assertEquals($event, $Message->getEvent());
	}
	
	public function test_it_can_add_metadata()
	{
		$event = $this->getMockBuilder('Milhojas\Library\EventSourcing\DomainEvent')
			->disableOriginalConstructor()
            ->getMock();
		$Message = EventMessage::record($event, 'Entity', 'entityid');
		$Message->addMetaData('data', 'some data');
		$this->assertEquals(array('data' => 'some data'), $Message->getMetaData());
	}
	
	public function test_it_can_add_an_array_of_metadata()
	{
		$event = $this->getMockBuilder('Milhojas\Library\EventSourcing\DomainEvent')
			->disableOriginalConstructor()
            ->getMock();
		$meta = array('data' => 'some data', 'data 2' => 'some data');
		$Message = EventMessage::record($event, 'Entity', 'entityid');
		$Message->addMetaData($meta);
		$this->assertEquals($meta, $Message->getMetaData());
	}
	
}

?>