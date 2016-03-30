<?php

namespace Tests\Infrastructure\Network\Printers;

use Milhojas\Infrastructure\Network\Printers\DSM745PrinterDriver;
use Milhojas\Library\ValueObjects\Technical\Ip;
use Milhojas\Domain\It\DeviceStatus;

/**
* Description
*/
class DSM745PrinterDriverTest extends \PHPUnit_Framework_Testcase
{
	
	public function test_it_works_ok()
	{
		$driver = new DSM745PrinterDriver();
		$this->assertFalse($driver->tonerLevelForColor('K', DSM745Mock::workingFine()->getStatus())->shouldReplace());
		$this->assertFalse($driver->paperLevelForTray(1, DSM745Mock::workingFine()->getStatus())->shouldReplace());
		$this->assertTrue(empty($driver->guessServiceCode(DSM745Mock::workingFine()->getStatus())));
	}
	
	public function test_it_needs_toner()
	{
		$driver = new DSM745PrinterDriver();
		$this->assertTrue($driver->tonerLevelForColor('K', DSM745Mock::withoutToner()->getStatus())->shouldReplace());
	}

	public function test_it_needs_service()
	{
		$driver = new DSM745PrinterDriver();
		$this->assertFalse(empty($driver->guessServiceCode(DSM745Mock::needingService()->getStatus())));
	}

	public function test_it_needs_paper()
	{
		$driver = new DSM745PrinterDriver();
		$this->assertTrue($driver->paperLevelForTray(1, DSM745Mock::withoutPaper()->getStatus())->shouldReplace());
	}

}


/**
* Simulates the behavior of a printer returning a minimal subset of the status web page
*/
class DSM745Mock implements DeviceStatus
{
	private $service;
	private $paper;
	private $toner;
	
	public function __construct($service, $paper, $toner)
	{
		$this->service = $service;
		$this->paper = $paper;
		$this->toner = $toner;
	}
	
	static public function workingFine()
	{
		return new static(
			true, 
			[1 => 5, 2 => 5, 3 => 5, 4 => 5], 
			['K' => 5]
		);
	}
	
	static public function withoutToner()
	{
		return new static(
			true, 
			[1 => 5, 2 => 5, 3 => 5, 4 => 5], 
			['K' => 0]
		);
	}
	
	static public function withoutPaper()
	{
		return new static(
			true, 
			[1 => 0, 2 => 5, 3 => 5, 4 => 5], 
			['K' => 5]
		);
	}
	
	static public function needingService()
	{
		return new static(
			false, 
			[1 => 5, 2 => 5, 3 => 5, 4 => 5], 
			['K' => 4]
		);
	}
	
	
	private function buildService()
	{
		$block = '';
		if (! $this->service) {
			$block = 'SC333'.chr(10);
		}
		return $block;
	}
	private function buildToner()
	{
		$block = '';
		foreach ($this->toner as $color => $level) {
			for ($i=0; $i < $level; $i++) { 
				$block .= sprintf('tonner_on.gif', $color).chr(10);
			}
		}
		return $block;
	}
	
	private function buildTrays()
	{
		$block = '';
		$levels = array(
			0 => '06',
			1 => '05',
			2 => '04',
			3 => '03',
			4 => '02', 
			5 => '01'
		);
		foreach ($this->paper as $tray => $level) {
			$block .= sprintf('iconk%s-ss.gif', $levels[$level]).chr(10);
		}
		return $block;
	}
	public function getStatus($force = false)
	{
		$page = chr(10);
		$page .= 'Simulated status page'.chr(10);
		$page .= $this->buildService();
		$page .= $this->buildToner();
		$page .= $this->buildTrays();
		return $page;
	}
	
	public function isUp()
	{
		return true;
	}
	
	public function isListening()
	{
		return true;
	}
	
}



?>