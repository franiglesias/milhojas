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
	
	public function applyTested()
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
			->setMockClassName('Tested')->disableOriginalConstructor()
            ->getMock();
		$Entity->apply($Event);
		$this->assertEquals(1, count($Entity->getEvents()));
	}
	
	public function test_it_can_not_apply_event()
	{

		$Entity = new TestESEntity();
		$Event = $this->getMockBuilder('Milhojas\Library\EventSourcing\DomainEvent')
			->setMockClassName('Tested')->disableOriginalConstructor()
            ->getMock();

		$Entity->apply($Event);
	}
	
	public function test_it_can_reconstitute()
	{
		$Entity = new TestESEntity();
		$Event = $this->getMockBuilder('Milhojas\Library\EventSourcing\DomainEvent')
			->setMockClassName('Tested')->disableOriginalConstructor()
            ->getMock();
		$Entity->apply($Event);
		$Entity->apply($Event);
		$Entity->apply($Event);
		$NewEntity = TestESEntity::reconstitute($Entity->getEvents());
		$this->assertEquals(3, $NewEntity->getCounter());
	}
	
	
}
?>