<?php

namespace Tests\Infrastructure\Network\Printers;

use Milhojas\Infrastructure\Network\Printers\PrinterDriver;

/**
* Description
*/
class PrinterDriverTest extends \PHPUnit_Framework_Testcase
{
	public function test_it_initializes()
	{
		$printer = new PrinterDriver($loader, new MockPrinterDriver(), 1, ['K']);
	}
	
}


?>