<?php

namespace Tests\Infrastructure\Network\Printers;

use Milhojas\Infrastructure\Network\Printer;
use Milhojas\Infrastructure\Network\Printers\PrinterConfiguration;
use Milhojas\Domain\It\DeviceIdentity;
use Milhojas\Library\ValueObjects\Technical\Ip;
use Tests\Infrastructure\Network\Printers\Doubles\MockPrinterDriver;
use Tests\Infrastructure\Network\Printers\Doubles\MockStatus;

/**
* Description
*/
class PrinterTest extends \PHPUnit_Framework_Testcase
{
	public function test_it_initializes()
	{
		$printer = new Printer(
			new DeviceIdentity('Printer', 'Testing', new Ip('127.0.0.1')), 
			MockStatus::working(), 
			new MockPrinterDriver(),
			new PrinterConfiguration (1, ['K'])
		);
		$this->assertFalse($printer->needsService());
		$this->assertFalse($printer->needsSupplies());
	}
	
	public function test_it_know_when_need_supplies_paper()
	{
		$printer = new Printer(
			new DeviceIdentity('Printer', 'Testing', new Ip('127.0.0.1')), 
			MockStatus::withoutPaper(), 
			new MockPrinterDriver(),
			new PrinterConfiguration (1, ['K'])

		);
		$this->assertTrue($printer->needsSupplies());
	}
	
	public function test_it_know_when_need_supplies_toner()
	{
		$printer = new Printer(
			new DeviceIdentity('Printer', 'Testing', new Ip('127.0.0.1')), 
			MockStatus::withoutToner(), 
			new MockPrinterDriver(),
			new PrinterConfiguration (1, ['K'])

		);
		$this->assertTrue($printer->needsSupplies());
	}
	
	public function test_it_knows_when_need_service()
	{
		$printer = new Printer(
			new DeviceIdentity('Printer', 'Testing', new Ip('127.0.0.1')), 
			MockStatus::needingService(), 
			new MockPrinterDriver(),
			new PrinterConfiguration (1, ['K'])

		);
		$this->assertTrue($printer->needsService());
	}

	public function test_it_knows_when_is_down()
	{
		$printer = new Printer(
			new DeviceIdentity('Printer', 'Testing', new Ip('127.0.0.1')), 
			MockStatus::down(), 
			new MockPrinterDriver(),
			new PrinterConfiguration (1, ['K'])

		);
		$this->assertFalse($printer->isUp());
	}
	
	public function test_it_knows_when_is_not_listening()
	{
		$printer = new Printer(
			new DeviceIdentity('Printer', 'Testing', new Ip('127.0.0.1')), 
			MockStatus::closed(), 
			new MockPrinterDriver(),
			new PrinterConfiguration (1, ['K'])

		);
		$this->assertFalse($printer->isListening());
	}
	
}


?>