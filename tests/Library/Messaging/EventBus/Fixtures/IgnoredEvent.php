<?php

namespace Tests\Library\Messaging\EventBus\Fixtures;

use Milhojas\Library\Messaging\EventBus\Event;

/**
* Simple Event for tests
*/
class IgnoredEvent implements Event
{
	private $data;
public function __construct($data)
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
	
	public function __toString()
	{
		return '';
	}

}


?>