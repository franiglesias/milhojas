<?php

namespace Tests\Infrastructure\Persistence\Storage\Doubles;
use Milhojas\Library\EventSourcing\Domain\EventSourcedEntity;
use Milhojas\Library\ValueObjects\Identity\Id;
use Tests\Infrastructure\Persistence\Storage\Doubles\StoreEvent;
/**
* A simple object to use in tests
*/
class EventSourcedStoreObject extends EventSourcedEntity
{
	private $value;
	
	function __construct()
	{
	}
	
	static public function create($value)
	{
		$object = new static();
		$object->recordThat(new StoreEvent($value));
		return $object;
	}
	
	public function getId()
	{
		return new Id($this->value);
	}
	
	public function getValue()
	{
		return $this->value;
	}
	
	public function doSomething($value)
	{
		$this->recordThat(new StoreEvent($value));
	}
	
	public function applyStoreEvent(StoreEvent $event)
	{
		$this->value = $event->getValue();
	}
}

?>