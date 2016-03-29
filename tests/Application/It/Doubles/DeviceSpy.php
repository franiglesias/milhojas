<?php

namespace Tests\Application\It\Doubles;

use Milhojas\Infrastructure\Network\Device;

/**
* Description
*/
class DeviceSpy implements Device
{
	private $up;
	private $listening;
	private $supplies;
	private $service;
	private $report;
	private $fails;
	
	function __construct($up, $listening, $supplies, $service)
	{
		$this->up = $up;
		$this->listening = $listening;
		$this->supplies = $supplies;
		$this->service = $service;
	}
	
	static public function working()
	{
		return new static(true, true, false, false);
	}
	
	static public function needingSupplies()
	{
		return new static(true, true, true, false);
	}
	
	static public function needingService()
	{
		return new static(true, true, false, true);
	}
	
	static public function isDown()
	{
		return new static(false, false, false, false);
	}
	
	public function isUp() 
	{
		$this->reportThat(!$this->up, 'Device is down');
		return $this->up;
	}
	
	public function isListening() 
	{
		$this->reportThat(!$this->listening, 'Device is not listening');
		return $this->listening;
	}
	
	public function needsService()
	{	
		$this->reportThat($this->service, 'Device needs service');
		return $this->supplies;
	}
	
	public function needsSupplies()
	{
		$this->reportThat($this->supplies, 'Device needs supplies');
		return $this->service;
	}
	
	
	public function getReport()
	{
		return $this->report;
	}
	
	
	private function reportThat($value, $message)
	{
		if ($value) {
			$this->fails++;
		}
		$this->report[] = $value ? $message : '';
	}
	
	public function getFails()
	{
		return $this->fails;
	}
}

?>