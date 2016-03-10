<?php

namespace Tests\Infrastructure\Network;

use Milhojas\Infrastructure\Network\Driver;
use Milhojas\Infrastructure\Network\PrinterDriver;

/**
* Description
*/
class PrinterDriverTests extends \PHPUnit_Framework_Testcase
{
	public function test_it_accepts_adapter_in_constructor()
	{
		$adapter = new DumbPrinterAdapter(1, ['K']);
		$driver = new PrinterDriver($adapter);
	}
	
	public function test_it_reports_if_needs_service()
	{
		$adapter = new DumbPrinterAdapter(1, ['K']);
		$adapter->makeFail();
		$driver = new PrinterDriver($adapter);
		$this->assertTrue($driver->needsService());
	}
	
	public function test_it_reports_if_needs_supplies_because_empty_paper()
	{
		$adapter = new DumbPrinterAdapter(1, ['K']);
		$adapter->emptyPaper();
		$driver = new PrinterDriver($adapter);
		$this->assertTrue($driver->needsSupplies());
	}

	public function test_it_reports_if_needs_supplies_because_empty_toner()
	{
		$adapter = new DumbPrinterAdapter(1, ['K']);
		$adapter->emptyToner();
		$driver = new PrinterDriver($adapter);
		$this->assertTrue($driver->needsSupplies());
	}

	public function test_it_reports_if_needs_supplies_because_empty_both()
	{
		$adapter = new DumbPrinterAdapter(1, ['K']);
		$adapter->emptyPaper();
		$adapter->emptyToner();
		$driver = new PrinterDriver($adapter);
		$this->assertTrue($driver->needsSupplies());
	}
	
	public function test_it_reports_current_status()
	{
		$adapter = new DumbPrinterAdapter(1, ['K']);
		$adapter->emptyPaper();
		$adapter->emptyToner();
		$driver = new PrinterDriver($adapter);
		$this->assertTrue(!empty($driver->getReport()));
	}

	
}

?>