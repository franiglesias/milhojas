<?php

namespace Tests\Infrastructure\Network\Printers;

use Milhojas\Infrastructure\Network\Printers\DSM745PrinterAdapter;


/**
* Description
*/
class DSM745PrinterAdapterTest extends \PHPUnit_Framework_Testcase
{
	
	public function test_it_needs_toner()
	{
		$printer = new DSM745PrinterAdapter('172.16.0.224/web/guest/es/websys/webArch/topPage.cgi', 4);
		$this->assertTrue($printer->needsToner());
		return $printer;
	}
	/**
	 * @depends test_it_needs_toner
	 */
	public function test_it_needs_service($printer)
	{
		$this->assertFalse($printer->needsService());
		return $printer;
	}

	/**
	 * @depends test_it_needs_service
	 */
	public function test_it_needs_paper($printer)
	{
		$this->assertTrue($printer->needsPaper());
		return $printer;
	}

	/**
	 * @depends test_it_needs_paper
	 */
	public function test_it_returns_details($printer)
	{
		$this->assertTrue(!empty($printer->getDetails()));
	}
	
	
}


?>