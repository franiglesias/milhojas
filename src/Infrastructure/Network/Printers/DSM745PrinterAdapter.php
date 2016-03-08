<?php

namespace Milhojas\Infrastructure\Network\Printers;

use Milhojas\Infrastructure\Network\NetworkPrinter;

/**
* Printer Adapter for Ricoh DSM-745
*/
class DSM745PrinterAdapter implements PrinterAdapter
{
	private $page;
	private $trays;
	
	private $details;
	
	function __construct($url, $trays)
	{
		$this->page = file_get_contents('http://'.$url); 
		$this->trays = $trays;
		$this->details = array();
	}
	
	public function needsToner()
	{
		$needsToner = false;
		foreach (array('K') as $color) {
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
		if (preg_match('/\/images\/deviceStScall16.gif/', $this->page, $matches) > 0) {
			$needsService = true;
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
		preg_match_all('/\/images\/tonner_no\.gif/', $this->page, $matches);
		return count($matches[0]);
	}
	
	private function paperLevelForTray($tray)
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