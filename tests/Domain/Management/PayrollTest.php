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
		$fileName = 'payroll/enero/01_nombre_(apellido1 apellido2, nombre1 nombre 2)_empresa_22308_trabajador_130496_010216_ mensual.pdf';
		$file = new PayrollFile($fileName);
		$payroll = new Payroll($file);
	}
}


?>