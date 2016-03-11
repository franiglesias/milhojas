<?php

namespace Tests\Infrastructure\Network\Printers\Doubles;

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
	
	public function guessServiceCode($status)
	{
		return $status['service'];
	}
	
	public function tonerLevelForColor($color, $status)
	{
		return new SupplyLevel($status['toner']);
	}
	
	public function paperLevelForTray($tray, $status)
	{
		return new SupplyLevel($status['paper']);
	}
	
	public function getVendorInformation()
	{
		return new Vendor(static::VENDOR, static::MODEL);
	}
}

?>