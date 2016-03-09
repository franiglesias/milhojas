<?php

namespace Milhojas\Infrastructure\Network\Printers;

use Milhojas\Infrastructure\Network\Printers\AbstractPrinterAdapter;
use Milhojas\Library\ValueObjects\Technical\Ip;
use Milhojas\Library\ValueObjects\Technical\SupplyLevel;
use Milhojas\Infrastructure\Network\Printers\MPC4500SupplyLevel;
/**
* Printer Adapter for Ricoh MP-C4500
*/
class MPC4500PrinterAdapter extends AbstractPrinterAdapter
{
	const URL = '/web/guest/es/websys/webArch/topPage.cgi';

	protected function detectFail()
	{
		return !empty($this->guessServiceCode());
	}
	
	protected function guessServiceCode()
	{
		preg_match_all('/SC\d+/', $this->page, $matches);
		return implode(', ', $matches[0]);
	}
	
	protected function tonerLevelForColor($color)
	{
		preg_match_all('/deviceStToner('.$color.')\.gif/', $this->page, $matches);
		return new SupplyLevel(count($matches[1]));
	}
	
	protected function paperLevelForTray($tray)
	{
		preg_match_all('/deviceStP(.+?)_?16\.gif/', $this->page, $matches);
		return new MPC4500SupplyLevel($matches[1][$tray-1]);
	}
	
}

?>