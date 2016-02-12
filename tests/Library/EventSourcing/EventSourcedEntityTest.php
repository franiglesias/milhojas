<?php

namespace Tests\Library\EventSourcing;

use Milhojas\Library\EventSourcing\Domain\EventSourcedEntity;
use Milhojas\Library\EventSourcing\Domain\DomainEvent;

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
	
	public function recordThat(DomainEvent $event)
	{
		parent::recordThat($event);
	}
}


class EventSourcedEntityTest extends \PHPUnit_Framework_TestCase {
	
	protected function getEvent($name)
	{
		return $this->getMockBuilder('Milhojas\Library\EventSourcing\Domain\DomainEvent')
			->setMockClassName($name)->disableOriginalConstructor()
            ->getMock();
	}
	
	protected function itShouldHaveRecordedEvents($eventCount, $Entity)
	{
		$this->assertEquals($eventCount, $Entity->getEvents()->count());
	}
	
	protected function itShouldHaveVersionNumber($version, $Entity)
	{
		$this->assertAttributeEquals($version, 'version', $Entity);
	}
	
	protected function itShouldHaveNotRecordedEvents($Entity)
	{
		$this->itShouldHaveRecordedEvents(0, $Entity);
	}
	
	protected function itShouldNotHaveVersion($Entity)
	{
		$this->itShouldHaveVersionNumber(-1, $Entity);
	}
	
	public function test_new_entity_has_no_recorded_events()
	{
		$Entity = new TestESEntity();
		$this->itShouldHaveNotRecordedEvents($Entity);
		$this->itShouldNotHaveVersion($Entity);
	}
	
	public function test_it_applies_event()
	{
		$Entity = new TestESEntity();
		$Entity->recordThat($this->getEvent('Handled'));
		$this->itShouldHaveRecordedEvents(1, $Entity);
		$this->itShouldHaveVersionNumber(0, $Entity);
	}
	
	public function test_it_does_not_apply_unknown_event()
	{
		$Entity = new TestESEntity();
		$Entity->recordThat($this->getEvent('NoHandled'));
		$this->itShouldHaveNotRecordedEvents($Entity);
		$this->itShouldNotHaveVersion($Entity);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function test_it_does_not_record_a_event_that_can_not_be_handled()
	{
		$Entity = new TestESEntity();
		$Entity->recordThat($this->getEvent('Failed'));
	}	

	public function test_it_can_reconstitute()
	{
		$Entity = new TestESEntity();
		$Event = $this->getEvent('Handled');
		$Entity->recordThat($Event);
		$Entity->recordThat($Event);
		$Entity->recordThat($Event);

		$NewEntity = TestESEntity::reconstitute($Entity->getEvents());
		
		$this->itShouldHaveNotRecordedEvents($NewEntity);
		$this->itShouldHaveVersionNumber(2, $NewEntity);
		$this->assertEquals(3, $NewEntity->getCounter());
	}
	
	public function test_it_can_reconstitute_with_an_event_that_can_not_handle()
	{
		$Entity = new TestESEntity();
		$Event = $this->getEvent('Handled');
		$BadEvent = $this->getEvent('NoHandled');
		$Entity->recordThat($Event);
		$Entity->recordThat($BadEvent);
		$Entity->recordThat($Event);
		
		$NewEntity = TestESEntity::reconstitute($Entity->getEvents());
		$this->itShouldHaveNotRecordedEvents($NewEntity);
		$this->itShouldHaveVersionNumber(1, $NewEntity);
		$this->assertEquals(2, $NewEntity->getCounter());
	}
	
}
?>