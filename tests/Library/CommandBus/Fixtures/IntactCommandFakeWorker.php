<?php

namespace Tests\Library\CommandBus\Fixtures;

use Milhojas\Library\CommandBus\Workers\CommandWorker;
use Milhojas\Library\CommandBus\Command;

use Tests\Library\CommandBus\Fixtures\SimpleCommandHandler;

/**
* A simple worker that does not execute the command. It only registers itself in the test spy
*/
class IntactCommandFakeWorker implements CommandWorker
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
		$this->next->injectSpy($this->spy);
		$this->next->execute($command);
	}
}


?>