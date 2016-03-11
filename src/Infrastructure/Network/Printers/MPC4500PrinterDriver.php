<?php

namespace Milhojas\Infrastructure\Network\Printers;

use Milhojas\Infrastructure\Network\Printers\PrinterDriverInterface;


use Milhojas\Library\ValueObjects\Technical\Ip;
use Milhojas\Library\ValueObjects\Technical\SupplyLevel;
use Milhojas\Infrastructure\Network\Printers\MPC4500SupplyLevel;
/**
* Printer Adapter for Ricoh MP-C4500
*/
class MPC4500PrinterDriver extends PrinterDriverInterface
{
	const URL = '/web/guest/es/websys/webArch/topPage.cgi';
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
		return new SupplyLevel(count($matches[1]));
	}
	
	public function paperLevelForTray($tray)
	{
		preg_match_all('/deviceStP(.+?)_?16\.gif/', $status, $matches);
		return new MPC4500SupplyLevel($matches[1][$tray-1]);
	}
}

?>