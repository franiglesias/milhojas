<?php

namespace Milhojas\Infrastructure\Network\Printers;

use Milhojas\Infrastructure\Network\Printers\PrinterDriver;

use Milhojas\Library\ValueObjects\Technical\SupplyLevel;

/**
* Printer Adapter for Ricoh MP-C4500
*/

class MockPrinterDriver implements PrinterDriver

{
	const URL = 'url';
	const VENDOR = 'Printer';
	const MODEL = 'Working';
	
	private $paper;
	private $toner;
	private $service;
	
	public function __construct($paper, $toner, $service)
	{
		$this->paper = $paper;
		$this->toner = $toner;
		$this->service = $service;
	}
	
	public function guessServiceCode($status)
	{
		return $this->service;
	}
	
	public function tonerLevelForColor($color, $status)
	{
		return new SupplyLevel($this->toner);
	}
	
	public function paperLevelForTray($tray, $status)
	{
		return new SupplyLevel($this->paper);
	}
}

?>