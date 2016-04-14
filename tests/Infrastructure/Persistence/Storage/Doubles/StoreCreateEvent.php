<?php

namespace Tests\Infrastructure\Persistence\Storage\Doubles;

use Milhojas\Library\EventSourcing\Domain\Event;

class StoreCreateEvent implements Event
{
	
	private $value;
	private $id;
	
	function __construct($id, $value)
	{
		$this->value = $value;
		$this->id = $id;
	}
	
	public function getValue()
	{
		return $this->value;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getName()
	{
		return 'test.store_create_event';
	}
}

?>