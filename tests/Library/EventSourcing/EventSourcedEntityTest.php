<?php

namespace Tests\Library\EventSourcing;

use Milhojas\Library\EventSourcing\EventSourcedEntity;

class TestESEntity extends EventSourcedEntity {
	
	private $id;
	private $counter;
	
	public function __construct()
	{
		$this->counter = 0;
	}
	public function getEntityId()
	{
		return $this->id;
	}
	
	public function applyHandled()
	{
		$this->counter++;
	}
	
	public function getCounter()
	{
		return $this->counter;
	}
}

class EventSourcedEntityTest extends \PHPUnit_Framework_TestCase {
	
	public function test_it_applies_event()
	{
		$Entity = new TestESEntity();
		$Event = $this->getMockBuilder('Milhojas\Library\EventSourcing\DomainEvent')
			->setMockClassName('Handled')->disableOriginalConstructor()
            ->getMock();
		$Entity->apply($Event);
		$this->assertEquals(1, count($Entity->getEvents()));
		$this->assertAttributeEquals(0, 'playhead', $Entity);
	}
	
	public function test_it_does_not_apply_unknown_event()
	{
		$Entity = new TestESEntity();
		$Event = $this->getMockBuilder('Milhojas\Library\EventSourcing\DomainEvent')
			->setMockClassName('NoHandled')->disableOriginalConstructor()
            ->getMock();
		$Entity->apply($Event);
		$this->assertEquals(0, $Entity->getEvents()->count());
		$this->assertAttributeEquals(-1, 'playhead', $Entity);
	}
	
	public function test_it_does_not_record_a_event_that_can_not_be_handled()
	{
		$Entity = new TestESEntity();
		$Event = $this->getMockBuilder('Milhojas\Library\EventSourcing\DomainEvent')
			->setMockClassName('NoHandled')->disableOriginalConstructor()
            ->getMock();
		$Entity->apply($Event);
		$this->assertEquals(0, $Entity->getCounter());
		$this->assertAttributeEquals(-1, 'playhead', $Entity);
	}	

	public function test_it_can_reconstitute()
	{
		$Entity = new TestESEntity();
		$Event = $this->getMockBuilder('Milhojas\Library\EventSourcing\DomainEvent')
			->setMockClassName('Handled')->disableOriginalConstructor()
            ->getMock();
		$Entity->apply($Event);
		$Entity->apply($Event);
		$Entity->apply($Event);
		$NewEntity = TestESEntity::reconstitute($Entity->getEvents());
		$this->assertEquals(3, $NewEntity->getCounter());
		$this->assertAttributeEquals(2, 'playhead', $Entity);
	}
	
	public function test_it_can_reconstitute_with_an_event_that_can_not_handle()
	{
		$Entity = new TestESEntity();
		$Event = $this->getMockBuilder('Milhojas\Library\EventSourcing\DomainEvent')
			->setMockClassName('Handled')->disableOriginalConstructor()
            ->getMock();
		$BadEvent = $this->getMockBuilder('Milhojas\Library\EventSourcing\DomainEvent')
			->setMockClassName('NoHandled')->disableOriginalConstructor()
            ->getMock();
		$Entity->apply($Event);
		$Entity->apply($BadEvent);
		$Entity->apply($Event);
		$NewEntity = TestESEntity::reconstitute($Entity->getEvents());
		$this->assertEquals(2, $NewEntity->getCounter());
		$this->assertEquals(2, $NewEntity->getEvents()->count());
		$this->assertAttributeEquals(1, 'playhead', $Entity);
	}
	
}
?>