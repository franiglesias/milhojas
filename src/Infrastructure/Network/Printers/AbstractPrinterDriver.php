<?php

namespace Milhojas\Infrastructure\Network\Printers;

use Milhojas\Infrastructure\Network\Printers\PrinterDriver;
use Milhojas\Infrastructure\Network\StatusLoader;

abstract class AbstractPrinterDriver implements PrinterDriver
{
	const URL = '';
	const VENDOR = 'Generic';
	const MODEL = 'Printer';
	
	protected $status;
	protected $loader;
	protected $trays;
	protected $colors;
	
	public function __construct(StatusLoader $loader, $trays, $colors)
	{
		$this->loader = $loader;
		$this->trays = $trays;
		$this->colors = $colors;
	}
	
	public function needsService()
	{
		return !empty($this->guessServiceCode());
	}
	
	abstract public function guessServiceCode();
	abstract public function tonerLevelForColor($color);
	abstract public function paperLevelForTray($tray);
	
	public function requestStatus()
	{
		$this->status = $this->loader->getStatus();
	}
	
	public function getVendorInformation()
	{
		return new Vendor(static::VENDOR, static::MODEL);
	}
	
}

?>