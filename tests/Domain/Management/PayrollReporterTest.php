<?php

namespace Tests\Domain\Management;

use Milhojas\Domain\Management\PayrollReporter;

/**
* Description
*/
class PayrollReporterTest extends \PHPUnit_Framework_Testcase
{
	public function testItConstructs()
	{
		$reporter = new PayrollReporter(1, 10);
		$this->assertEquals(' 1 / 10', $reporter->__toString());
		$this->assertEquals(1, $reporter->getCurrent());
		$this->assertEquals(10, $reporter->getTotal());
	}
	
	public function testItRegistersAPayrollWasSent()
	{
		$reporter = new PayrollReporter(1, 10);
		$updatedReporter = $reporter->addSent();
		$this->assertEquals(1, $updatedReporter->getSent());
		$this->assertEquals(1, $reporter->getCurrent());
	}
	
	public function testAdvanceMaintainsCurrentData()
	{
		$reporter = new PayrollReporter(1, 10);
		$reporter = $reporter->addSent();
		$reporter = $reporter->advance();
		$this->assertEquals(1, $reporter->getSent());
		$this->assertEquals(2, $reporter->getCurrent());
	}
	
	public function testItRegistersAPayrollWasNotFound()
	{
		$reporter = new PayrollReporter(1, 10);
		$updatedReporter = $reporter->addNotFound();
		$this->assertEquals(1, $updatedReporter->getNotFound());
		$this->assertEquals(1, $reporter->getCurrent());
	}

	public function testItRegistersMessageFailed()
	{
		$reporter = new PayrollReporter(1, 10);
		$updatedReporter = $reporter->addFailed();
		$this->assertEquals(1, $updatedReporter->getFailed());
		$this->assertEquals(1, $reporter->getCurrent());
	}
	
	public function testItReturnsJson()
	{
		$reporter = new PayrollReporter(5, 25);
		$expected = array(
			'current' => 5, 
			'total' => 25,
			'sent' => 0,
			'notFound' => 0,
			'failed' => 0
		);
		$this->assertEquals(json_encode($expected), $reporter->asJson());
	}


}

?>
