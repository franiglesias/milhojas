<?php

namespace Tests\Library\EventBus\Fixtures;

use Milhojas\Library\EventSourcing\Domain\Event;

/**
* Simple Event for tests
*/
class IgnoredEvent implements Event
{
	private $data;
	
	function __construct($data)
	{
		$this->data = $data;
	}
	
	public function getName()
	{
		return 'ignored.event';
	}
	
	public function getData()
	{
		return $this->data;
	}
}


?>