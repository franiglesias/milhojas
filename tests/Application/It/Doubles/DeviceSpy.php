<?php

namespace Tests\Application\It\Doubles;

use Milhojas\Domain\It\Device;
use Milhojas\Domain\It\DeviceIdentity;

/**
* Simulates a device under different conditions
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
	
	public function getIdentity()
	{
		return $this->identity;
	}
	
	function __construct(DeviceIdentity $identity, $up, $listening, $supplies, $service)
	{
		$this->identity = $identity;
		$this->up = $up;
		$this->listening = $listening;
		$this->supplies = $supplies;
		$this->service = $service;
	}
	
	# static named constructors define working conditions on the simulaes device
	
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
		return new static($identity, false, true, false, false);
	}
	
	static public function twoFails(DeviceIdentity $identity) 
	{
		return new static($identity, true, true, true, true);
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
		if (! $this->fails) {
			return [new DeviceWasOK($this->identity)];
		}
		return $this->report;
	}
	
	
	private function reportThat($value, $message)
	{
		if ($value) {
			$this->fails++;
		}
		$this->report = $value ? $message : '';
	}
	
	public function getFails()
	{
		return $this->fails;
	}
}

?>