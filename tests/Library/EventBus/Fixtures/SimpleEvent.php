<?php

namespace Tests\Library\EventBus\Fixtures;

use Milhojas\Library\EventBus\Event;

/**
* A simple Event for tests
*/
class SimpleEvent implements Event
{
	private $data;
	
	function __construct($data)
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
