<?php

namespace Tests\Infrastructure\Network\Printers;

use Milhojas\Infrastructure\Network\Printers\MPC4500PrinterAdapter;
use Milhojas\Library\ValueObjects\Technical\Ip;

/**
* Description
*/
class MPC4500PrinterAdapterTest extends \PHPUnit_Framework_Testcase
{
	
	public function test_it_needs_toner()
	{
		$printer = new MPC4500PrinterAdapter(new Ip('172.16.0.222'), 4, ['K','C','M', 'K']);
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