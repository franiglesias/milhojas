<?php

namespace Milhojas\Infrastructure\Network\Printers;

use Milhojas\Infrastructure\Network\Printers\PrinterDriver;

use Milhojas\Library\ValueObjects\Technical\SupplyLevel;
use Milhojas\Infrastructure\Network\Printers\MPC4500SupplyLevel;
use Milhojas\Library\ValueObjects\Technical\Vendor;

/**
* Printer Adapter for Ricoh MP-C4500
*/

class MPC4500PrinterDriver implements PrinterDriver

{
	const URL = 'web/guest/es/websys/webArch/topPage.cgi';
	const VENDOR = 'Ricoh';
	const MODEL = 'MP-C4500';
	
	public function guessServiceCode($status)
	{
		preg_match_all('/SC\d+/', $status, $matches);
		return implode(', ', $matches[0]);
	}
	
	public function tonerLevelForColor($color, $status)
	{
		preg_match_all('/deviceStToner('.$color.')\.gif/', $status, $matches);
		if ($color == 'K' && count($matches[1]) === 0) {
			return $this->tonerLevelForColor('U', $status);
		}
		return new SupplyLevel(count($matches[1]));
	}
	
	public function paperLevelForTray($tray, $status)
	{
		preg_match_all('/deviceStP(Nend|end|100|75|50|25)_?16\.gif/', $status, $matches);
		return new MPC4500SupplyLevel($matches[1][$tray-1]);
	}
	
	public function getVendorInformation()
	{
		return new Vendor(static::VENDOR, static::MODEL);
	}
}

?>
