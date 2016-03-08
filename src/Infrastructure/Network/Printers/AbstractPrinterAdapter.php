<?php

namespace Milhojas\Infrastructure\Network\Printers;

use Milhojas\Infrastructure\Network\NetworkPrinter;
use Milhojas\Library\ValueObjects\Technical\Ip;

/**
* Printer Adapter for Ricoh DSM-745
*/
abstract class AbstractPrinterAdapter implements PrinterAdapter
{
	const URL = '';
	protected $page;
	protected $trays;
	protected $colors;
	
	protected $details;
	
	function __construct(Ip $ip, $trays, array $colors)
	{
		$this->page = file_get_contents('http://'.$ip->getIp().self::URL); 
		$this->trays = $trays;
		$this->details = array();
		$this->colors = $colors;
	}
	
	public function needsToner()
	{
		$needsToner = false;
		foreach ($this->colors as $color) {
			if ($this->tonerLevelForColor($color) <= 1) {
				$this->details[] = sprintf('Replace toner for color %s', $color);
				$needsToner = true;
			}
		}
		return $needsToner;
	}
	
	public function needsPaper()
	{
		$needsPaper = false;
		for ($tray=1; $tray <= $this->trays; $tray++) { 
			if ($this->paperLevelForTray($tray) <= 1) {
				$this->details[] = sprintf('Put paper in tray %s', $tray);
				$needsPaper = true;
			}
		}
		return $needsPaper;
	}
	
	public function needsService()
	{
		$needsService = false;
		if ($this->detectFail()) {
			$needsService = true;
			$this->details[] = sprintf('Printer needs Service with errors: %s', $this->guessServiceCode());
		}
		return $needsService;
	}
	
	public function getDetails()
	{
		return $this->details;
	}
	
	abstract protected function detectFail();
	
	abstract protected function guessServiceCode();
	
	abstract protected function tonerLevelForColor($color);
	
	abstract protected function paperLevelForTray($tray);
	
}

?>