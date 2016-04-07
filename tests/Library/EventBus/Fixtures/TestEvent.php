<?php

namespace Tests\Library\EventBus\Fixtures;

use Milhojas\Library\EventSourcing\Domain\Event;

/**
* A simple Event for tests
*/
class TestEvent implements Event
{
	private $data;
	
	function __construct($data)
	{
		$this->data = $data;
	}
	
	public function getName()
	{
		return 'test.event';
	}
	
	public function getData()
	{
		return $this->data;
	}
}


?>