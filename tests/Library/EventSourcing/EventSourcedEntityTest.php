<?php

namespace Tests\Library\EventSourcing;

use Milhojas\Library\EventSourcing\EventSourcedEntity;

class EventSourcedEntityTest extends \PHPUnit_Framework_TestCase {
	
	public function test_it_applies_event()
	{

		$Entity = $this->getMockBuilder('Milhojas\Library\EventSourcing\EventSourcedEntity')
			->setMethods(array('applyTested'))
				->disableOriginalConstructor()
					->getMockForAbstractClass();
		$Event = $this->getMockBuilder('Milhojas\Library\EventSourcing\DomainEvent')
			->setMockClassName('Tested')->disableOriginalConstructor()
            ->getMock();

		$Entity->expects($this->once())->method('handle')->with($this->equalTo($Event));
		$Entity->apply($Event);
	}
	
	public function test_it_can_not_apply_event()
	{

		$Entity = $this->getMockBuilder('Milhojas\Library\EventSourcing\EventSourcedEntity')
				->disableOriginalConstructor()
					->getMockForAbstractClass();

		$Event = $this->getMockBuilder('Milhojas\Library\EventSourcing\DomainEvent')
			->setMockClassName('Tested')->disableOriginalConstructor()
            ->getMock();

		$Entity->expects($this->once())->method('handle')->with($this->equalTo($Event));
		$Entity->apply($Event);
	}
	
	
}
?>