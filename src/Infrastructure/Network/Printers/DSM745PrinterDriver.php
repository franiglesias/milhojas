<?php

namespace Milhojas\Infrastructure\Network\Printers;

use Milhojas\Infrastructure\Network\Printers\PrinterDriver;
use Milhojas\Infrastructure\Network\Printers\DSM745SupplyLevel;

use Milhojas\Library\ValueObjects\Technical\Ip;
use Milhojas\Library\ValueObjects\Technical\Vendor;
use Milhojas\Library\ValueObjects\Technical\SupplyLevel;
/**
* Printer Adapter for Ricoh DSM-745
*/
class DSM745PrinterAdapter implements PrinterDriver
{
	const URL = '/web/guest/es/websys/webArch/topPage.cgi';
	const VENDOR = 'Ricoh';
	const MODEL = 'DSM-745';
	
	private $status;
	
	protected function detectFail()
	{
		return !empty($this->guessServiceCode());
	}
	
	protected function guessServiceCode()
	{ 
		preg_match_all('/SC\d+/', $this->status, $matches);
		return implode(', ', $matches[0]);
	}
	
	protected function tonerLevelForColor($color)
	{
		preg_match_all('/tonner_on\.gif/', $this->status, $matches);
		return new SupplyLevel(count($matches[0]));
	}
	
	protected function paperLevelForTray($tray)
	{
		preg_match_all('/iconk(\d\d)-ss\.gif/', $this->status, $matches);
		return new DSM745SupplyLevel($matches[1][$tray-1]);
	}
	
	public function requestStatus()
	{
		
	}
	public function getVendorInformation()
	{
		
	}
	
}

?>