<?php 

namespace Tests\Library\CommandBus\Utils;

use Milhojas\Library\CommandBus\CommandBus;
use Milhojas\Library\CommandBus\Command;
use Milhojas\Library\CommandBus\Workers\CommandWorker;
/**
* A simple test spy
*/
class CommandBusSpy implements CommandBus
{
	private $busUnderTest;
	public $workers;
	private $commands;
	private $pipeline;
	
	function __construct(CommandBus $busUnderTest)
	{
		$this->busUnderTest = $busUnderTest;
		$this->extractWorkers();
	}
	
	private function extractWorkers()
	{
		$reflect = new \ReflectionObject($this->busUnderTest);
		$property = $reflect->getProperty('chain');
		$property->setAccessible(true);
		$this->workers = $property->getValue($this->busUnderTest);
	}

	public function execute(Command $command)
	{
		$this->workers->injectSpy($this);
		$this->workers->execute($command);
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
		$this->commands[] = get_class($command);
	}
	
	public function registerWorker(CommandWorker $worker)
	{
		$parts = explode('\\', get_class($worker));
		$this->pipeline[] = end($parts);
	}
	
	/**
	 * Review the log as array
	 *
	 * @return array
	 * @author Fran Iglesias
	 */
	public function getResult()
	{
		return array(
			'commands' => $this->commands,
			'pipeline' => $this->pipeline
		);
	}
	
	public function getPipeline()
	{
		return $this->pipeline;
	}
}

 ?>