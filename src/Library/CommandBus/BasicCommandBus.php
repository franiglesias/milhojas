<?php

namespace Milhojas\Library\CommandBus;

use Milhojas\Library\CommandBus\CommandBus;

/**
* A very Basic Command Bus that builds a chain of responsibility with an array of workers
*/

class BasicCommandBus implements CommandBus
{
	protected $workersChain;
	
	function __construct(array $workers)
	{
		$this->workersChain = $this->buildWorkersChain($workers);
	}
	
	/**
	 * Builds the responsibility chain
	 *
	 * @param string $workers 
	 * @return the chain
	 * @author Francisco Iglesias Gómez
	 */
	protected function buildWorkersChain($workers)
	{
		$chain = array_pop($workers);
		while (count($workers) > 0) {
			$prev = array_pop($workers);
			$prev->setNext($chain);
			$chain = $prev;
		}
		return $chain;
	}

	/**
	 * Execute command
	 *
	 * @param Command $command 
	 * @return void
	 * @author Fran Iglesias
	 */
	public function execute(Command $command)
	{
		$this->workersChain->execute($command);
	}
}
?>
