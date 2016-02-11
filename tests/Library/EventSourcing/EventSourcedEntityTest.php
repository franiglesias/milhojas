<?php

namespace Tests\Library\EventSourcing;

use Milhojas\Library\EventSourcing\Domain\EventSourcedEntity;

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
	
	public function applyFailed()
	{
		throw new \InvalidArgumentException("Error Processing Request", 1);
	}
	
	public function getCounter()
	{
		return $this->counter;
	}
}


class EventSourcedEntityTest extends \PHPUnit_Framework_TestCase {
	
	public function getEvent($name)
	{
		return $this->getMockBuilder('Milhojas\Library\EventSourcing\Domain\DomainEvent')
			->setMockClassName($name)->disableOriginalConstructor()
            ->getMock();
	}
	
	public function test_it_applies_event()
	{
		$Entity = new TestESEntity();
		$Entity->apply($this->getEvent('Handled'));
		$this->assertEquals(1, count($Entity->getEvents()));
		$this->assertAttributeEquals(0, 'version', $Entity);
	}
	
	public function test_it_does_not_apply_unknown_event()
	{
		$Entity = new TestESEntity();
		$Entity->apply($this->getEvent('NoHandled'));
		$this->assertEquals(0, $Entity->getEvents()->count());
		$this->assertAttributeEquals(-1, 'version', $Entity);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function test_it_does_not_record_a_event_that_can_not_be_handled()
	{
		$Entity = new TestESEntity();
		$Entity->apply($this->getEvent('Failed'));
		$this->assertEquals(0, $Entity->getCounter());
		$this->assertAttributeEquals(-1, 'version', $Entity);
	}	

	public function test_it_can_reconstitute()
	{
		$Entity = new TestESEntity();
		$Event = $this->getEvent('Handled');
		$Entity->apply($Event);
		$Entity->apply($Event);
		$Entity->apply($Event);
		$NewEntity = TestESEntity::reconstitute($Entity->getEvents());
		$this->assertEquals(3, $NewEntity->getCounter());
		$this->assertAttributeEquals(2, 'version', $Entity);
	}
	
	public function test_it_can_reconstitute_with_an_event_that_can_not_handle()
	{
		$Entity = new TestESEntity();
		$Event = $this->getEvent('Handled');
		$BadEvent = $this->getEvent('NoHandled');
		$Entity->apply($Event);
		$Entity->apply($BadEvent);
		$Entity->apply($Event);
		
		$NewEntity = TestESEntity::reconstitute($Entity->getEvents());
		$this->assertEquals(2, $NewEntity->getCounter());
		$this->assertEquals(2, $NewEntity->getEvents()->count());
		$this->assertAttributeEquals(1, 'version', $Entity);
	}
	
}
?>