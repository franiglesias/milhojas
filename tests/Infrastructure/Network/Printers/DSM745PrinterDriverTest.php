<?php

namespace Tests\Infrastructure\Network\Printers;

use Milhojas\Infrastructure\Network\Printers\DSM745PrinterDriver;
use Milhojas\Library\ValueObjects\Technical\Ip;

/**
* Description
*/
class DSM745PrinterDriverTest extends \PHPUnit_Framework_Testcase
{
	public function getFullWorking()
	{
		return new DSM745Mock(
			true, 
			[1 => 5, 2 => 5, 3 => 5, 4 => 5], 
			['K' => 5]
		);
	}
	
	public function getNeedsToner()
	{
		return new DSM745Mock(
			true, 
			[1 => 5, 2 => 5, 3 => 5, 4 => 5], 
			['K' => 0]
		);
	}
	
	public function getNeedsPaper()
	{
		return new DSM745Mock(
			true, 
			[1 => 0, 2 => 5, 3 => 5, 4 => 5], 
			['K' => 5]
		);
	}
	
	public function getNeedsService()
	{
		return new DSM745Mock(
			false, 
			[1 => 5, 2 => 5, 3 => 5, 4 => 5], 
			['K' => 4]
		);
	}
	
	public function test_it_works_ok()
	{
		// $page = file_get_contents('http://172.16.0.224'.DSM745PrinterDriver::URL);
		$printer = new DSM745PrinterDriver(4, ['K']);
		$printer->requestStatus($this->getFullWorking()->getData());
		$this->assertFalse($printer->needsToner());
		$this->assertFalse($printer->needsPaper());
		$this->assertFalse($printer->needsService());
	}
	
	public function test_it_needs_toner()
	{
		$printer = new DSM745PrinterDriver(4, ['K']);
		$printer->requestStatus($this->getNeedsToner()->getData());
		$this->assertTrue($printer->needsToner());
	}
	public function test_it_needs_service()
	{
		$printer = new DSM745PrinterDriver(4, ['K']);
		$printer->requestStatus($this->getNeedsService()->getData());
		$this->assertTrue($printer->needsService());
	}

	public function test_it_needs_paper()
	{
		$printer = new DSM745PrinterDriver(4, ['K']);
		$printer->requestStatus($this->getNeedsPaper()->getData());
		$this->assertTrue($printer->needsPaper());
	}

	public function test_it_records_details()
	{
		$printer = new DSM745PrinterDriver(4, ['K']);
		$printer->requestStatus($this->getNeedsPaper()->getData());
		$printer->needsPaper();
		$this->assertFalse(empty($printer->getDetails()));
	}

}


/**
* Simulates the behavior of a printer returning a minimal subset of the status web page
*/
class DSM745Mock
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