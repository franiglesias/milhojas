<?php 

namespace Tests\Library\Messaging\CommandBus\Utils;

use Milhojas\Library\Messaging\CommandBus\CommandBus;
use Milhojas\Library\Messaging\CommandBus\Command;
use Milhojas\Library\Messaging\CommandBus\Workers\CommandWorker;

/**
* A simple test spy
*/

class CommandBusSpy implements CommandBus
{
	public $workersChain;
	private $busUnderTest;
	private $commands;
	private $pipeline;
	private $log;
public function __construct(CommandBus $busUnderTest)
	{
		$this->busUnderTest = $busUnderTest;
		$this->extractWorkers();
	}
	
	private function extractWorkers()
	{
		$reflect = new \ReflectionObject($this->busUnderTest);
		$property = $reflect->getProperty('workersChain');
		$property->setAccessible(true);
		$this->workersChain = $property->getValue($this->busUnderTest);
	}

	public function execute(Command $command)
	{
		$this->workersChain->injectSpy($this);
		$this->workersChain->execute($command);
		$this->registerCommand($command);
	}
	
	/**
	 * Add text lines to a log
	 *
	 * @param string $line 
	 * @return void
	 * @author Fran Iglesias
	 */
	public function registerCommand(Command $command)
	{
		$this->commands[] = $this->getShortClassName($command);
	}
	
	public function registerWorker(CommandWorker $worker)
	{
		$this->pipeline[] = $this->getShortClassName($worker);
	}
	
	public function registerExecution(CommandWorker $worker, Command $command)
	{
		$this->log[] = sprintf('Worker %s has received command %s.', $this->getShortClassName($worker), $this->getShortClassName($command));
	}
	
	public function registerDelegation(CommandWorker $worker, CommandWorker $next, Command $command)
	{
		$this->log[] = sprintf('Worker %s has passed command %s to worker %s.', $this->getShortClassName($worker), $this->getShortClassName($command), $this->getShortClassName($next));
	}
	
	public function registerChainEnd(CommandWorker $worker, Command $command)
	{
		$this->log[] = sprintf('Worker %s can\'t delegate command %s.', $this->getShortClassName($worker), $this->getShortClassName($command));
		
	}
	
	private function getShortClassName($object)
	{
		$parts = explode('\\', get_class($object));
		return end($parts);
	}
		
	public function getPipeline()
	{
		return $this->pipeline;
	}
	
	public function getCommandsExecuted()
	{
		return $this->commands;
	}
	
	public function getStory()
	{
		return $this->log;
	}
}

?>
