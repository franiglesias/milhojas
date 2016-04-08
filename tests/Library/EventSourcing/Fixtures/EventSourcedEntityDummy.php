<?php

namespace Tests\Library\EventSourcing\Fixtures;

use Milhojas\Library\EventSourcing\Domain\Event;
use Milhojas\Library\ValueObjects\Identity\Id;

use Milhojas\Library\EventSourcing\Domain\EventSourcedEntity;

class EventSourcedEntityDummy extends EventSourcedEntity {
	
	private $id;
	private $counter;
	
	public function __construct()
	{
		$this->id = Id::create();
		$this->counter = 0;
	}
	public function getId()
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
	
	public function recordThat(Event $event)
	{
		parent::recordThat($event);
	}
}


?>