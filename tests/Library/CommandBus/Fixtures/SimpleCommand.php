<?php

namespace Tests\Library\CommandBus\Fixtures;

use Milhojas\Library\CommandBus\Command;

class SimpleCommand implements Command {
	private $message;
	
	public function __construct($message)
	{
		$this->message = $message;
	}
	
	public function getMessage()
	{
		return $this->message;
	}
}


?>