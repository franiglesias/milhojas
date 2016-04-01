<?php

namespace Tests\Infrastructure\Network\Printers;

use Milhojas\Infrastructure\Network\Printers\MPC4500PrinterDriver;
use Milhojas\Library\ValueObjects\Technical\Ip;
use Milhojas\Domain\It\DeviceStatus;
/**
* Description
*/
class MPC4500PrinterDriverTest extends \PHPUnit_Framework_Testcase
{
	
	public function test_it_works_ok()
	{
		$driver = new MPC4500PrinterDriver();
		$this->assertFalse($driver->tonerLevelForColor('K', MPC4500Mock::workingFine()->updateStatus())->shouldReplace());
		$this->assertFalse($driver->paperLevelForTray(1, MPC4500Mock::workingFine()->updateStatus())->shouldReplace());
		$this->assertTrue(empty($driver->guessServiceCode(MPC4500Mock::workingFine()->updateStatus())));
	}
	
	public function test_it_needs_toner()
	{
		$driver = new MPC4500PrinterDriver();
		$this->assertTrue($driver->tonerLevelForColor('K', MPC4500Mock::withoutToner()->updateStatus())->shouldReplace());
	}

	public function test_it_needs_service()
	{
		$driver = new MPC4500PrinterDriver();
		$this->assertFalse(empty($driver->guessServiceCode(MPC4500Mock::needingService()->updateStatus())));
	}

	public function test_it_needs_paper()
	{
		$driver = new MPC4500PrinterDriver();
		$this->assertTrue($driver->paperLevelForTray(1, MPC4500Mock::withoutPaper()->updateStatus())->shouldReplace());
	}

}


/**
* Simulates the behavior of a printer returning a minimal subset of the status web page
*/
class MPC4500Mock implements DeviceStatus
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
				$block .= sprintf('deviceStToner%s.gif', $color).chr(10);
			}
		}
		return $block;
	}
	
	private function buildTrays()
	{
		$block = '';
		$levels = array(
			0 => 'end',
			1 => 'Nend',
			2 => '25_',
			3 => '50_',
			4 => '75_', 
			5 => '100_'
		);

		foreach ($this->paper as $tray => $level) {
			$block .= sprintf('deviceStP%s16.gif', $levels[$level]).chr(10);
		}
		return $block;
	}
	public function updateStatus($force = false)
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
	
	public function getIp()
	{
		return new Ip('127.0.0.1');
	}
	
}

?>