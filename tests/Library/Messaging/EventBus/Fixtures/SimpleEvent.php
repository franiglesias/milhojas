<?php

namespace Tests\Library\Messaging\EventBus\Fixtures;

use Milhojas\Library\Messaging\EventBus\Event;

/**
* A simple Event for tests
*/
class SimpleEvent implements Event
{
	private $data;
public function __construct($data)
	{
		$this->data = $data;
	}
	
	public function getName()
	{
		return 'simple.event';
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
