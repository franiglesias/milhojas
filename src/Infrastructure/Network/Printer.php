<?php

namespace Milhojas\Infrastructure\Network;

use Milhojas\Infrastructure\Network\Printers\PrinterDriver;
/**
* Description
*/
class Printer implements Device
{
	private $driver;
	private $device;
	private $loader;
	private $messages;
	private $colors;
	private $trays;
	
	function __construct(DeviceIdentity $device, StatusLoader $loader, PrinterDriver $driver)
	{
		$this->driver = $driver;
		$this->loader = $loader;
		$this->colors = ['K', 'C', 'M', 'Y'];
		$this->trays = 4;
	}
	
	public function isUp()
	{
		# code...
	}
	
	public function isListening()
	{
		# code...
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
	}
	
	private function hasFailed()
	{
		$serviceCodes = $this->driver->guessServiceCode($this->loader->getStatus());
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
		foreach ($this->colors as $color) {
			if ($this->driver->tonerLevelForColor($color, $this->loader->getStatus())->shouldReplace()) {
				$needsToner = true;
				$this->recordThat(sprintf('Replace toner for color %s', $color));
			}
		}
		return $needsToner;
	}
	
	public function needsPaper()
	{
		$needsPaper = false;
		for ($tray=1; $tray <= $this->trays; $tray++) { 
			if ($this->driver->paperLevelForTray($tray, $this->loader->getStatus())->shouldReplace()) {
				$needsPaper = true;
				$this->recordThat(sprintf('Put paper in tray %s', $tray));
			}
		}
		return $needsPaper;
		
	}
	
	protected function recordThat($message)
	{
		$this->messages[] = $message;
	}
	
}


abstract class AbstractPrinterAdapter 
{
	const URL = '';
	const MODEL = '';
	const VENDOR = '';
	
	protected $status;
	protected $trays;
	protected $colors;
	
	protected $details;
	
	function __construct($trays, array $colors)
	{
		// Use static instead of self to get late static binding so we can override class constants
		$this->status = ''; 
		$this->trays = $trays;
		$this->details = array();
		$this->colors = $colors;
	}
	

	
	
	public function getReport()
	{
		$report = array(sprintf('Status report for %s %s', static::VENDOR, static::MODEL));
		return array_merge($report, $this->getTonerReport(), $this->getPaperReport());
	}

	private function getTonerReport()
	{
		$report = array('Toner report');
		foreach ($this->colors as $color) {
			$report[] = sprintf('Color %s level: %s', $color, $this->tonerLevelForColor($color)->getLevel());
		}
		return $report;
	}

	private function getPaperReport()
	{
		$report = array('Paper report');
		for ($tray=1; $tray <= $this->trays; $tray++) { 
			$report[] = sprintf('Paper tray %s level: %s', $tray, $this->paperLevelForTray($tray)->getLevel());
		}
		return $report;
	}

	
	public function getDetails()
	{
		return $this->details;
	}

	
	public function getVendor()
	{
		return new Vendor(static::VENDOR, static::MODEL);
	}
	
	public function getStatusUrl()
	{
		return static::URL;
	}

	protected function recordThat($message)
	{
		$this->details[] = $message;
	}
	

	
}


?>