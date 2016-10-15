<?php

namespace Milhojas\Infrastructure\Network\Printers;

use Milhojas\Infrastructure\Network\Printers\PrinterDriver;
use Milhojas\Library\ValueObjects\Technical\SupplyLevel;
use Milhojas\Library\ValueObjects\Technical\Vendor;
use Milhojas\Infrastructure\Network\Printers\DSM745SupplyLevel;


/**
* Printer Adapter for Ricoh DSM-745
*/
class DSM745PrinterDriver implements PrinterDriver
{
	const URL = 'web/guest/es/websys/webArch/topPage.cgi';
	const VENDOR = 'Ricoh';
	const MODEL = 'DSM-745';
	
	public function guessServiceCode($status)
	{ 
		preg_match_all('/SC\d+/', $status, $matches);
		return implode(', ', $matches[0]);
	}
	
	public function tonerLevelForColor($color, $status)
	{
		preg_match_all('/tonner_on\.gif/', $status, $matches);
		return new SupplyLevel(count($matches[0]));
	}
	
	public function paperLevelForTray($tray, $status)
	{
		preg_match_all('/iconk(\d\d)-ss\.gif/', $status, $matches);
		return new DSM745SupplyLevel($matches[1][$tray-1]);
	}
	public function getVendorInformation()
	{
		return new Vendor(static::VENDOR, static::MODEL);
	}
}



?>
