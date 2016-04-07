<?php

namespace Milhojas\Domain\Contents\Events;

use Milhojas\Library\EventSourcing\Domain\Event;
/**
* An existent post was retired
*/
class PostWasRetired implements Event
{
	private $id;
	
	function __construct($id)
	{
		$this->id = $id;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getName()
	{
		return 'milhojas.post_was_retired';
	}
	
}

?>