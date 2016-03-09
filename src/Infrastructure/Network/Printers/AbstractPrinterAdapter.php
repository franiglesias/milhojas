<?php

namespace Milhojas\Infrastructure\Network\Printers;

use Milhojas\Infrastructure\Network\NetworkPrinter;
use Milhojas\Library\ValueObjects\Technical\Ip;
use Milhojas\Library\ValueObjects\Technical\SupplyLevel;

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
	
	function __construct($page, $trays, array $colors)
	{
		// Use satic instead of self to get late static binding so we can override class constants
		$this->page = $page; 
		$this->trays = $trays;
		$this->details = array();
		$this->colors = $colors;
	}
	
	public function needsToner()
	{
		$needsToner = false;
		foreach ($this->colors as $color) {
			if ($this->tonerLevelForColor($color)->shouldReplace()) {
				$needsToner = true;
				$this->recordThat(sprintf('Replace toner for color %s', $color));
			}
		}
		return $needsToner;
	}
	
	public function needsPaper()
	{
		$needsPaper = false;
		for ($tray=1; $tray <= $this->trays; $tray++) { 
			if ($this->paperLevelForTray($tray)->shouldReplace()) {
				$needsPaper = true;
				$this->recordThat(sprintf('Put paper in tray %s', $tray));
			}
		}
		return $needsPaper;
	}
	
	public function needsService()
	{
		$needsService = false;
		if ($this->detectFail()) {
			$needsService = true;
			$this->recordThat(sprintf('Printer needs Service with errors: %s', $this->guessServiceCode() ));
		}
		return $needsService;
	}
	
	public function getDetails()
	{
		return $this->details;
	}
	
	protected function recordThat($message)
	{
		$this->details[] = $message;
	}
	
	abstract protected function detectFail();
	
	abstract protected function guessServiceCode();
	
	abstract protected function tonerLevelForColor($color);
	
	abstract protected function paperLevelForTray($tray);
	
}

?>