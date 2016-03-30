<?php

namespace Milhojas\Infrastructure\Network\Printers;

use Milhojas\Infrastructure\Network\Printers\PrinterDriver;
use Milhojas\Library\ValueObjects\Technical\SupplyLevel;
use Milhojas\Library\ValueObjects\Technical\Vendor;

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

class DSM745SupplyLevel extends SupplyLevel {
	
	private $levels = array(
		'01' => 5,
		'02' => 4,
		'03' => 3,
		'04' => 2,
		'05' => 1,
		'06' => 0
	);
	
	public function __construct($level)
	{
		$this->isValidLevel($level);
		parent::__construct($this->levels[$level]);
	}
	
	private function isValidLevel($level)
	{
		if (! isset($this->levels[$level])) {
			throw new \InvalidArgumentException(sprintf("Invalid level format %s provided by DSM745 Adapter", $level), 1);
		}
	}
	
}


?>