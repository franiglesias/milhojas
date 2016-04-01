<?php

namespace Milhojas\Infrastructure\Network;

use Milhojas\Infrastructure\Network\Printers\PrinterDriver;
use Milhojas\Infrastructure\Network\Printers\PrinterConfiguration;
use Milhojas\Domain\It\DeviceIdentity;
use Milhojas\Domain\It\DeviceStatus;
use Milhojas\Domain\It\Device;
/**
* Description
*/
class Printer implements Device
{
	private $driver;
	private $device;
	private $status;
	private $messages;
	private $configuration;

	
	function __construct(DeviceIdentity $device, DeviceStatus $status, PrinterDriver $driver, PrinterConfiguration $configuration)
	{
		$this->device = $device;
		$this->driver = $driver;
		$this->status = $status;
		$this->configuration = $configuration;
		$this->messages = array();
	}
	
	public function getIdentity()
	{
		return $this->device;
	}
	
	public function isUp()
	{
		return $this->status->isUp();
	}
	
	public function isListening()
	{
		return $this->status->isListening();
	}
		
	public function needsSupplies()
	{
		return ($this->needsToner() || $this->needsPaper());
	}
	
	public function needsService()
	{
		return $this->hasFailed();
	}
	
	public function getReport()
	{
		return implode(chr(10), $this->messages);
	}
	
	private function hasFailed()
	{
		$serviceCodes = $this->driver->guessServiceCode($this->status->getStatus());
		$needsService = false;
		if ($serviceCodes) {
			$needsService = true;
			$this->recordThat(sprintf('Printer needs Service with errors: %s', $serviceCodes ));
		}
		return $needsService;
	}
	
	
	private function needsToner()
	{
		$needsToner = false;
		foreach ($this->configuration->getColors() as $color) {
			if ($this->getTonerLevel($color)->shouldReplace()) {
				$needsToner = true;
				$this->recordThat(sprintf('Replace toner for color %s (Level: %s)', $color, $this->getTonerLevel($color)->getVerboseLevel()));
			}
		}
		return $needsToner;
	}
	
	private function getTonerLevel($color)
	{
		return $this->driver->tonerLevelForColor($color, $this->status->getStatus());
	}
	
	private function needsPaper()
	{
		$needsPaper = false;
		for ($tray=1; $tray <= $this->configuration->getTrays(); $tray++) { 
			if ($this->getPaperLevel($tray)->shouldReplace()) {
				$needsPaper = true;
				$this->recordThat(sprintf('Put paper in tray %s (Level: %s)', $tray, $this->getPaperLevel($tray)->getVerboseLevel()));
			}
		}
		return $needsPaper;
		
	}
	
	private function getPaperLevel($tray)
	{
		return $this->driver->paperLevelForTray($tray, $this->status->getStatus());
	}
	
	protected function recordThat($message)
	{
		$this->messages[] = $message;
	}
	
}


?>