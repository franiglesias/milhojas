<?php

namespace Tests\Infrastructure\Network;

use Milhojas\Infrastructure\Network\Printers\AbstractPrinterAdapter;
use Milhojas\Library\ValueObjects\Technical\SupplyLevel;
/**
* Printer Adapter for tests
*/
class DumbPrinterAdapter extends AbstractPrinterAdapter
{
	const URL = '';
	const VENDOR = 'Tests';
	const MODEL = 'Printer';
	
	private $needsService = false;
	private $tonerLevel = 5;
	private $paperLevel = 5;
	
	protected function detectFail()
	{
		return !empty($this->guessServiceCode());
	}
	
	protected function guessServiceCode()
	{
		return $this->needsService;
	}
	
	protected function tonerLevelForColor($color)
	{
		return new SupplyLevel($this->tonerLevel);
	}
	
	protected function paperLevelForTray($tray)
	{
		return new SupplyLevel($this->paperLevel);
	}
	
	public function makeFail()
	{
		$this->needsService = true;
	}
	
	public function emptyPaper()
	{
		$this->paperLevel = 0;
	}
	
	public function emptyToner()
	{
		$this->tonerLevel = 0;
	}
	
}

?>