<?php

namespace Tests\Domain\Management;

use Milhojas\Domain\Management\Payroll;
use Milhojas\Infrastructure\Persistence\Management\PayrollFile;
/**
* Description
*/
class PayrollTest extends \PHPUnit_Framework_Testcase
{
	
	public function test_it_links_to_a_payroll_file()
	{
		$payroll = new Payroll('123', 'Nombre Apellido', 'email@example.com', 'datafile', 'male');
		$this->assertEquals('Nombre Apellido', $payroll->getName());
		$this->assertEquals('123', $payroll->getId());
		$this->assertEquals('datafile', $payroll->getFile());
		$this->assertEquals('Payroll id: 123 (email@example.com)', $payroll->__toString());
	}
}


?>
