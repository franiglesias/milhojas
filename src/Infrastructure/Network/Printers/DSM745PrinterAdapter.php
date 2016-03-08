<?php

namespace Milhojas\Infrastructure\Network\Printers;

use Milhojas\Library\ValueObjects\Technical\Ip;
use Milhojas\Infrastructure\Network\Printers\AbstractPrinterAdapter;

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
		preg_match_all('/\/images\/tonner_on\.gif/', $this->page, $matches);
		return count($matches[0]);
	}
	
	protected function paperLevelForTray($tray)
	{
		preg_match_all('/iconk(\d\d)-ss\.gif/', $this->page, $matches);
		switch ($matches[1][$tray]) {
			case '06':
				$level = 0;
				break;
			case '05':
				$level = 1;
				break;
			case '04':
				$level = 2;
				break;
			case '03':
				$level = 3;
				break;
			case '02':
				$level = 4;
				break;
			default:
				$level = 5;
				break;
		}
		return $level;
	}
	
}

?>