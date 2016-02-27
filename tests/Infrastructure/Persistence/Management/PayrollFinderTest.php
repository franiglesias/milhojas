<?php

namespace Tests\Infrastructure\Persistence\Management;

use Milhojas\Infrastructure\Persistence\Management\PayrollFinder;
use Symfony\Component\Finder\Finder;
use org\bovigo\vfs\vfsStream;

/**
* Description
*/
class PayrollFinderTest extends \PHPUnit_Framework_Testcase
{
	
    private $root;

    public function setUp()
    {
        $this->root = vfsStream::setup("payroll");
    }

	
	public function test_it_loads_files()
	{
		$file1 = '01_nombre_(apellido1 apellido2, nombre1 nombre2)_empresa_22308_trabajador_130496_010216_mensual.pdf';
		$file2 = '02_nombre_(apellido3 apellido4, nombre3)_empresa_22308_trabajador_130286_010216_mensual.pdf';
		$test = vfsStream::newDirectory('test')->at($this->root);
		
		vfsStream::newFile($file1)->at($test);
		vfsStream::newFile($file2)->at($test);
		
		$finder = new PayrollFinder(new Finder());
		$finder->getFiles(vfsStream::url('payroll/test'));
		
		$this->assertEquals(2, iterator_count($finder->getIterator()));
	}
	
}


?>