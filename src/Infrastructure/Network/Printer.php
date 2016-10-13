<?php

namespace Milhojas\Infrastructure\Network;

use Milhojas\Infrastructure\Network\Printers\PrinterDriver;
use Milhojas\Infrastructure\Network\Printers\PrinterConfiguration;
use Milhojas\Domain\It\DeviceIdentity;
use Milhojas\Domain\It\DeviceStatus;
use Milhojas\Domain\It\Device;

use Milhojas\Infrastructure\Network\BaseDevice;
/**
* Description
*/
class Printer extends BaseDevice
{
	private $driver;
	private $configuration;
	
	function __construct(DeviceIdentity $device, DeviceStatus $status, PrinterDriver $driver, PrinterConfiguration $configuration)
	{
		$this->device = $device;
		$this->driver = $driver;
		$this->status = $status;
		$this->configuration = $configuration;
		$this->messages = array();
	}
		
	public function needsSupplies()
	{
		$needsToner = $this->needsToner();
		$needsPaper = $this->needsPaper();
		return ($needsToner || $needsPaper);
	}
	
	public function needsService()
	{
		return $this->hasFailed();
	}
	
	private function hasFailed()
	{
		$serviceCodes = $this->driver->guessServiceCode($this->status->updateStatus());
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
				$this->recordThat(sprintf('Replace toner for color %s (Level: %s)', $color, $this->getTonerLevel($color)->verbose()));
			}
		}
		return $needsToner;
	}
	
	private function getTonerLevel($color)
	{
		return $this->driver->tonerLevelForColor($color, $this->status->updateStatus());
	}
	
	private function needsPaper()
	{
		$needsPaper = false;
		for ($tray=1; $tray <= $this->configuration->getTrays(); $tray++) { 
			if ($this->getPaperLevel($tray)->shouldReplace()) {
				$needsPaper = true;
				$this->recordThat(sprintf('Put paper in tray %s (Level: %s)', $tray, $this->getPaperLevel($tray)->verbose()));
			}
		}
		return $needsPaper;
	}
	
	private function getPaperLevel($tray)
	{
		return $this->driver->paperLevelForTray($tray, $this->status->updateStatus());
	}
}

?>