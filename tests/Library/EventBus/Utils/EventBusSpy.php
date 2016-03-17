<?php

namespace Tests\Library\EventBus\Utils;

use Milhojas\Library\EventBus\EventBus;
use Milhojas\Library\EventBus\Event;
use Milhojas\Library\EventBus\EventHandler;


/**
* Description
*/
class EventBusSpy implements EventBus
{
	private $busUnderTest;
	private $recordedHandlers;
	
	function __construct(EventBus $busUnderTest)
	{
		$this->busUnderTest = $busUnderTest;
		$this->recordedHandlers = array();
	}
	
	private function extract()
	{
		$reflect = new \ReflectionObject($this->busUnderTest);
		$property = $reflect->getProperty('handlers');
		$property->setAccessible(true);
		$handlers = $property->getValue($this->busUnderTest);
		return $handlers;
	}
	
	public function recordHandler($event, $handler)
	{
		$this->recordedHandlers[$event->getName()][] = $handler;
	}
	
	public function handle(Event $event)
	{
		$this->busUnderTest->handle($event);
	}
	
	public function addHandler($eventName, EventHandler $handler)
	{
		$this->busUnderTest->addHandler($eventName, $handler);
	}
	
	public function assertWasRegistered($eventName, EventHandler $handler)
	{
		$handlers = $this->extract();
		foreach ($handlers[$eventName] as $test) {
			if ($test == $handler) {
				return true;
			}
		}
		return false;
	}
	
	public function eventWasHandled($eventName)
	{
		return in_array($eventName, $this->getHandledEvents());
	}
	
	public function getHandledEvents()
	{
		return array_keys($this->recordedHandlers);
	}
	
	public function getRecordedHandlers()
	{
		return $this->recordedHandlers;
	}
	
}
?>