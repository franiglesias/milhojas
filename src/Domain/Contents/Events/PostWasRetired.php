<?php

namespace Milhojas\Domain\Contents\Events;

use Milhojas\Library\EventBus\Event;
/**
* An existent post was retired
*/
class PostWasRetired implements Event
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
		return 'contents.post_was_retired';
	}
	
}

?>
