<?php

namespace Tests\Infrastructure\Network\Printers;

use Milhojas\Infrastructure\Network\Printers\MPC4500PrinterDriver;
use Milhojas\Library\ValueObjects\Technical\Ip;

/**
* Description
*/
class MPC4500PrinterDriverTest extends \PHPUnit_Framework_Testcase
{
	public function getFullWorking()
	{
		return new MPC4500Mock(
			true, 
			[1 => '50', 2 => '50', 3 => '50', 4 => '50'], 
			['K' => 4, 'C' => 4, 'M' => '4', 'Y' => '4']
		);
	}
	
	public function getNeedsToner()
	{
		return new MPC4500Mock(
			true, 
			[1 => '50', 2 => '50', 3 => '50', 4 => '50'], 
			['K' => 0, 'C' => 4, 'M' => '4', 'Y' => '4']
		);
	}
	
	public function getNeedsPaper()
	{
		return new MPC4500Mock(
			true, 
			[1 => 'end', 2 => '50', 3 => '50', 4 => '50'], 
			['K' => 5, 'C' => 4, 'M' => '4', 'Y' => '4']
		);
	}
	
	public function getNeedsService()
	{
		return new MPC4500Mock(
			false, 
			[1 => '50', 2 => '50', 3 => '50', 4 => '50'], 
			['K' => 0, 'C' => 4, 'M' => '4', 'Y' => '4']
		);
	}
	
	
	
	// public function test_it_works_ok()
	// {
	// 	$printer = new MPC4500PrinterDriver(4, ['K','C','M', 'K']);
	// 	$printer->requestStatus($this->getFullWorking()->getData());
	// 	$this->assertFalse($printer->needsToner());
	// 	$this->assertFalse($printer->needsPaper());
	// 	$this->assertFalse($printer->needsService());
	// }
	//
	// public function test_it_needs_toner()
	// {
	// 	$printer = new MPC4500PrinterDriver(4, ['K','C','M', 'K']);
	// 	$printer->requestStatus($this->getNeedsToner()->getData());
	// 	$this->assertTrue($printer->needsToner());
	// }
	//
	// public function test_it_needs_service()
	// {
	// 	$printer = new MPC4500PrinterDriver(4, ['K','C','M', 'K']);
	// 	$printer->requestStatus($this->getNeedsService()->getData());
	// 	$this->assertTrue($printer->needsService());
	// }
	//
	// public function test_it_needs_paper()
	// {
	// 	$printer = new MPC4500PrinterDriver(4, ['K','C','M', 'K']);
	// 	$printer->requestStatus($this->getNeedsPaper()->getData());
	// 	$this->assertTrue($printer->needsPaper());
	// 	return $printer;
	// }
	//
	// public function dont_test_it_returns_details()
	// {
	// 	$printer = new MPC4500PrinterDriver(4, ['K','C','M', 'K']);
	// 	$printer->requestStatus($this->getFullWorking()->getData());
	// 	$this->assertTrue(!empty($printer->getDetails()));
	// }
	
	public function test_somethinf()
	{
		# code...
	}
}


/**
* Simulates the behavior of a printer returning a minimal subset of the status web page
*/
class MPC4500Mock
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
		foreach ($this->paper as $tray => $level) {
			$block .= sprintf('deviceStP%s_16.gif', $level).chr(10);
		}
		return $block;
	}
	public function getData()
	{
		$page = chr(10);
		$page .= 'Simulated status page'.chr(10);
		$page .= $this->buildService();
		$page .= $this->buildToner();
		$page .= $this->buildTrays();
		return $page;
	}
}

?>