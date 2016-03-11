<?php

namespace Milhojas\Infrastructure\Network\Printers;

use Milhojas\Infrastructure\Network\Printers\PrinterDriver;

use Milhojas\Library\ValueObjects\Technical\Ip;
use Milhojas\Library\ValueObjects\Technical\SupplyLevel;
use Milhojas\Infrastructure\Network\Printers\MPC4500SupplyLevel;
/**
* Printer Adapter for Ricoh MP-C4500
*/
class MPC4500PrinterAdapter implements PrinterDriver
{
	const URL = '/web/guest/es/websys/webArch/topPage.cgi';
	const VENDOR = 'Ricoh';
	const MODEL = 'MP-C4500';
	
	protected $status;
	
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
		preg_match_all('/deviceStToner('.$color.')\.gif/', $this->status, $matches);
		return new SupplyLevel(count($matches[1]));
	}
	
	protected function paperLevelForTray($tray)
	{
		preg_match_all('/deviceStP(.+?)_?16\.gif/', $this->status, $matches);
		return new MPC4500SupplyLevel($matches[1][$tray-1]);
	}
	
	public function requestStatus()
	{
		
	}
	public function getVendorInformation()
	{
		
	}
	
}

?>