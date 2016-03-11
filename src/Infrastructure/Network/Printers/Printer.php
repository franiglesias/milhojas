<?php

namespace Milhojas\Infrastructure\Network\Printers;

use Milhojas\Infrastructure\Network\Printers\PrinterDriver;
use Milhojas\Infrastructure\Network\StatusLoader;

class PrinterDriver
{
	protected $loader;
	protected $trays;
	protected $colors;
	protected $driver;
	
	public function __construct(StatusLoader $loader, PrinterDriverInterface $driver, $trays, $colors)
	{
		$this->loader = $loader;
		$this->driver = $driver;
		$this->trays = $trays;
		$this->colors = $colors;
	}
	
	public function needsService()
	{
		return !empty($this->guessServiceCode());
	}
	
	public function guessServiceCode() 
	{
		$this->driver->guessServiceCode($this->requestStatus());
	}
	public function tonerLevelForColor($color) 
	{
		$this->driver->tonerLevelForColor($color, $this->requestStatus());
	}
	public function paperLevelForTray($tray) 
	{
		$this->driver->paperLevelForTray($tray, $this->requestStatus());
	}
	
	private function requestStatus()
	{
		$this->status = $this->loader->getStatus();
	}
	
	public function getVendorInformation()
	{
		return $this->driver->getVendorInformation();
	}
	
}

?>