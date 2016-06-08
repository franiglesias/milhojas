<?php

namespace Tests\Library\EventSourcing\Fixtures;

use Milhojas\Library\EventSourcing\Domain\Event;

/**
* Description
*/
class CreationEvent implements Event
{
	private $id;
	
	public function __construct($id)
	{
		$this->id = $id;
	}
	public function getId()
	{
		return $this->id;
	}
	
	public function getName()
	{
		return 'creation_event';
	}
}


?>