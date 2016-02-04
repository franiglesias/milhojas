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
}

?>