<?php

namespace Tests\Application\It\Doubles;

use Milhojas\Infrastructure\Network\Device;
use Milhojas\Infrastructure\Network\DeviceIdentity;

use Milhojas\Application\It\Events\DeviceIsOK;
use Milhojas\Application\It\Events\DeviceIsDown;
use Milhojas\Application\It\Events\DeviceIsNotListening;
use Milhojas\Application\It\Events\DeviceNeedsSupplies;
use Milhojas\Application\It\Events\DeviceNeedsService;


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
	private $identity;
	
	function __construct(DeviceIdentity $identity, $up, $listening, $supplies, $service)
	{
		$this->identity = $identity;
		$this->up = $up;
		$this->listening = $listening;
		$this->supplies = $supplies;
		$this->service = $service;
	}
	
	static public function working(DeviceIdentity $identity)
	{
		return new static($identity, true, true, false, false);
	}
	
	static public function needingSupplies(DeviceIdentity $identity)
	{
		return new static($identity, true, true, true, false);
	}
	
	static public function needingService(DeviceIdentity $identity)
	{
		return new static($identity, true, true, false, true);
	}
	
	static public function isDown(DeviceIdentity $identity)
	{
		return new static($identity, false, false, false, false);
	}
	
	public function isUp() 
	{
		$this->reportThat(!$this->up, new DeviceIsDown($this->identity, 'Device is down'));
		return $this->up;
	}
	
	public function isListening() 
	{
		$this->reportThat(!$this->listening, new DeviceIsNotListening($this->identity, 'Device is not listening'));
		return $this->listening;
	}
	
	public function needsService()
	{	
		$this->reportThat($this->service, new DeviceNeedsService($this->identity, 'Device needs service'));
		return $this->supplies;
	}
	
	public function needsSupplies()
	{
		$this->reportThat($this->supplies, new DeviceNeedsSupplies($this->identity, 'Device needs supplies'));
		return $this->service;
	}
	
	
	public function getReport()
	{
		if (! $this->fails) {
			return [new DeviceIsOK($this->identity)];
		}
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