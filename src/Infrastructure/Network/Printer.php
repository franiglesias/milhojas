<?php

namespace Milhojas\Infrastructure\Network;

use Milhojas\Infrastructure\Network\Printers\PrinterDriver;
/**
* Description
*/
class Printer implements Device
{
	private $adapter;
	
	function __construct(PrinterAdapter $adapter)
	{
		$this->adapter = $adapter;
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
		return $this->adapter->needsPaper() || $this->adapter->needsToner();
	}
	
	public function needsService()
	{
		return $this->adapter->needsService();
	}
	
	public function getReport()
	{
		return $this->adapter->getReport();
	}
	
	public function requestStatus(DeviceReporter $reporter)
	{
		$this->adapter->requestStatus($reporter->requestStatus($this->adapter->getStatusUrl()));
	}
}


abstract class AbstractPrinterAdapter implements PrinterAdapter, KnowsVendorInformation
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
	
	public function requestStatus($status)
	{
		$this->status = $status;
	}
	
	public function needsToner()
	{
		$needsToner = false;
		foreach ($this->colors as $color) {
			if ($this->tonerLevelForColor($color)->shouldReplace()) {
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
			if ($this->paperLevelForTray($tray)->shouldReplace()) {
				$needsPaper = true;
				$this->recordThat(sprintf('Put paper in tray %s', $tray));
			}
		}
		return $needsPaper;
	}
	
	public function needsService()
	{
		$needsService = false;
		if ($this->detectFail()) {
			$needsService = true;
			$this->recordThat(sprintf('Printer needs Service with errors: %s', $this->guessServiceCode() ));
		}
		return $needsService;
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
	
	
	
	abstract protected function detectFail();
	
	abstract protected function guessServiceCode();
	
	abstract protected function tonerLevelForColor($color);
	
	abstract protected function paperLevelForTray($tray);
	
}


?>