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
	private $id;
	
	function __construct()
	{
	}
	
	static public function create(Id $id, $value)
	{
		$object = new static();
		$object->id = $id;
		$object->recordThat(new StoreEvent($value));
		return $object;
	}
	
	public function getId()
	{
		return $this->id;
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