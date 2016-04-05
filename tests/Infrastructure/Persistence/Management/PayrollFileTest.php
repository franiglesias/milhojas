<?php


namespace Tests\Infrastructure\Persistence\Management;

use Milhojas\Infrastructure\Persistence\Management\PayrollFile;

use Tests\Infrastructure\Persistence\Management\Fixtures\PayrollFileSystem; 

use org\bovigo\vfs\vfsStream;

class PayrollFileTest extends \PHPUnit_Framework_Testcase {

    private $root;

    public function setUp()
    {
		$this->root = (new PayrollFileSystem())->get();
    }
		
	public function test_it_extracts_the_name()
	{
		$path = vfsStream::url('payroll/test/01_nombre_(apellido1 apellido2, nombre1 nombre2)_empresa_22308_trabajador_130496_010216_mensual.pdf');
		$file = new PayrollFile(new \SplFileInfo($path));
		$this->assertEquals('Nombre1 Nombre2 Apellido1 Apellido2', $file->extractName());
	}
	
	public function test_it_return_the_real_path()
	{
		$path = vfsStream::url('payroll/test/01_nombre_(apellido1 apellido2, nombre1 nombre2)_empresa_22308_trabajador_130496_010216_mensual.pdf');
		$file = new PayrollFile(new \SplFileInfo($path));
		$this->assertEquals('vfs://payroll/test/01_nombre_(apellido1 apellido2, nombre1 nombre2)_empresa_22308_trabajador_130496_010216_mensual.pdf', $file->getRealPath());
	}

	public function test_it_extracts_the_name_single_name()
	{
		$path = vfsStream::url('payroll/test/03_nombre_(apellido1 apellido2, nombre1)_empresa_22308_trabajador_130496_010216_mensual.pdf');
		$file = new PayrollFile(new \SplFileInfo($path));
		$this->assertEquals('Nombre1 Apellido1 Apellido2', $file->extractName());
	}
	
	/**
	 * @expectedException Milhojas\Infrastructure\Persistence\Management\Exceptions\MalformedPayrollFileName
	 */
	public function test_null_if_can_not_find_name()
	{
		$path = vfsStream::url('payroll/test/04_nom_(apellido1 apellido2, nombre1)_empresa_22308_trabajador_130496_010216_mensual.pdf');
		$file = new PayrollFile(new \SplFileInfo($path));
		$this->assertNull($file->extractName());
	}
	
	public function test_it_extracts_the_id()
	{
		$path = vfsStream::url('payroll/test/01_nombre_(apellido1 apellido2, nombre1 nombre2)_empresa_22308_trabajador_130496_010216_mensual.pdf');
		$file = new PayrollFile(new \SplFileInfo($path));
		$this->assertEquals('130496', $file->extractId());
	}
}

?>