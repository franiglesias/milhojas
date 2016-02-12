<?php

namespace Milhojas\Domain\Contents\Events;

use Milhojas\Library\EventSourcing\Domain\DomainEvent;
/**
* An existent post was retired
*/
class PostWasRetired implements DomainEvent
{
	private $id;
	
	function __construct($id)
	{
		$this->id = $id;
	}
	
	public function getEntityId()
	{
		return $this->id;
	}
	
}

?>