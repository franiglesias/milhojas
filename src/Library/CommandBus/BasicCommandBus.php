<?php

namespace Milhojas\Library\CommandBus;

use Milhojas\Library\CommandBus\CommandBus;
use Milhojas\Library\CommandBus\Workers\CommandWorker;
/**
* Description
*/
class BasicCommandBus implements CommandBus
{
	private $workers;
	private $chain;
	
	function __construct(array $workers)
	{
		$chain = array_shift($workers);
		$first = $chain;
		while (count($workers) > 0) {
			$next = array_shift($workers);
			$chain->setNext($next);
			$chain = $next;
		}
		$this->chain = $first;
	}
	
	/**
	 * Appends worker to the worker chain
	 *
	 * @param string $worker 
	 * @return void or Exception if no worker is passed
	 * @author Fran Iglesias
	 */
	private function append($worker)
	{
		$this->isValidWorker($worker);
		$this->workers[] = $worker;
	}
	
	/**
	 * TypeHinting error throw exception
	 *
	 * @param string $worker 
	 * @return void
	 * @author Fran Iglesias
	 */
	private function isValidWorker($worker)
	{
		if (! is_a($worker, 'Milhojas\Library\CommandBus\Workers\CommandWorker')) {
			throw new \InvalidArgumentException('Worker should implement Milhojas\Library\CommandBus\CommandWorker Interface', 1);
		}
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
		$this->chain->execute($command);
	}
}
?>