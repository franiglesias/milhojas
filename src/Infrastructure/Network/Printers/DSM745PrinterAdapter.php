<?php

namespace Milhojas\Infrastructure\Network\Printers;

use Milhojas\Infrastructure\Network\Printers\AbstractPrinterAdapter;
use Milhojas\Infrastructure\Network\Printers\DSM745SupplyLevel;

use Milhojas\Library\ValueObjects\Technical\Ip;
use Milhojas\Library\ValueObjects\Technical\SupplyLevel;
/**
* Printer Adapter for Ricoh DSM-745
*/
class DSM745PrinterAdapter extends AbstractPrinterAdapter
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
		preg_match_all('/tonner_on\.gif/', $this->page, $matches);
		return new SupplyLevel(count($matches[0]));
	}
	
	protected function paperLevelForTray($tray)
	{
		preg_match_all('/iconk(\d\d)-ss\.gif/', $this->page, $matches);
		return new DSM745SupplyLevel($matches[1][$tray-1]);
	}
	
}

?>