<?php

namespace Tests\Library\CommandBus\Fixtures;

use Milhojas\Library\CommandBus\Workers\CommandWorker;
use Milhojas\Library\CommandBus\Command;

/**
* A simple worker that does not execute the command. It only registers itself in the test spy
*/
class FakeCommandWorker extends CommandWorker
{
	public $spy;
	
	public function injectSpy($spy)
	{
		$this->spy = $spy;
	}
	
	protected function delegateNext(Command $command)
	{
		if (!$this->next) {
			$this->spy->registerChainEnd($this, $command);
			return;
		}
		$this->next->injectSpy($this->spy);
		$this->spy->registerDelegation($this, $this->next, $command);
		$this->next->execute($command);
	}
	
	function execute(Command $command)
	{
		$this->spy->registerExecution($this, $command);
		$this->spy->registerWorker($this);
		$this->delegateNext($command);
	}
}


?>