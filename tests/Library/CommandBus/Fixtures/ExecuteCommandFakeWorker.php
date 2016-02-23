<?php

namespace Tests\Library\CommandBus\Fixtures;

use Milhojas\Library\CommandBus\Command;
use Milhojas\Library\CommandBus\Workers\CommandWorker;

use Tests\Library\CommandBus\Fixtures\SimpleCommandHandler;

/**
* A simple worker that executes a Command with the SimpleCommandHandler
*/
class ExecuteCommandFakeWorker implements CommandWorker
{
	public $spy;
	protected $next;
	
	public function __construct()
	{
	}
	
	public function injectSpy($spy)
	{
		$this->spy = $spy;
	}
	
	public function setNext(CommandWorker $next)
	{
		$this->next = $next;
	}
	function execute(Command $command)
	{
		if (!$this->next) {
			return;
		}
		$this->spy->registerWorker($this);
		$handler = new SimpleCommandHandler();
		$handler->handle($command);
		$this->next->injectSpy($this->spy);
		$this->next->execute($command);
	}
}


?>