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
	private $workers;
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
		$property = $reflect->getProperty('workers');
		$property->setAccessible(true);
		$this->workers = $property->getValue($this->busUnderTest);
	}

	public function execute(Command $command)
	{
		foreach ($this->workers as $worker) {
			$this->registerWorker($worker);
			$worker->execute($command);
		}
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
		$this->pipeline[] = get_class($worker);
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
}

 ?>