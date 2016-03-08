<?php

namespace Milhojas\Infrastructure\Network\Printers;

use Milhojas\Infrastructure\Network\NetworkPrinter;
use Milhojas\Library\ValueObjects\Technical\Ip;
/**
* Printer Adapter for Ricoh MP-C4500
*/
class MPC4500PrinterAdapter implements PrinterAdapter
{
	const URL = '/web/guest/es/websys/webArch/topPage.cgi';
	private $page;
	private $trays;
	private $colors;
	
	private $details;
	
	function __construct(Ip $ip, $trays, array $colors)
	{
		$this->page = file_get_contents('http://'.$ip->getIp().self::URL); 
		$this->trays = $trays;
		$this->colors = $colors;
		$this->details = array();
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
		if ($needsService = preg_match('/\/images\/deviceStScall16.gif/', $this->page, $matches) > 0) {
			$this->details[] = sprintf('Printer needs Service with errors: %s', $this->guessServiceCode());
		}
		return $needsService;
	}
	
	public function getDetails()
	{
		return $this->details;
		return implode(chr(10), $this->details);
	}
	
	private function guessServiceCode()
	{
		preg_match_all('/SC\d+/', $this->page, $matches);
		return implode(', ', $matches[0]);
	}
	
	private function tonerLevelForColor($color)
	{
		preg_match_all('/deviceStToner('.$color.')\.gif/', $this->page, $matches);
		return count($matches[1]);
	}
	
	private function paperLevelForTray($tray)
	{
		preg_match_all('/deviceStP(.+?)_?16\.gif/', $this->page, $matches);
		switch ($matches[1][$tray]) {
			case 'end':
				$level = 0;
				break;
			case 'Nend':
				$level = 1;
				break;
			case '25':
				$level = 2;
				break;
			case '50':
				$level = 3;
				break;
			case '75':
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