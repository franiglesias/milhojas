<?php

namespace Tests\Domain\Management;

use Milhojas\Domain\Management\Payroll;
use Milhojas\Infrastructure\Persistence\Management\PayrollFile;
/**
* Description
*/
class PayrollTest extends \PHPUnit_Framework_Testcase
{
	private $root;
    public function setUp()
    {
		$structure = array(
			'payroll' => array(
				'email.dat',
				'enero' => array(
					'01_nombre_(apellido1 apellido2, nombre1 nombre2)_empresa_22308_trabajador_130496_010216_mensual.pdf',
					'02_nombre_(apellido3 apellido4, nombre3)_empresa_22308_trabajador_130286_010216_mensual.pdf'
				),
			)
		);
    }
	
	
	public function test_it_links_to_a_payroll_file()
	{
		$payroll = new Payroll('123', 'Nombre Apellido', 'email@example.com', 'datafile');
		$this->assertEquals('Nombre Apellido', $payroll->getName());
		$this->assertEquals('123', $payroll->getId());
		$this->assertEquals('datafile', $payroll->getFile());
	}
}


?>