<?php

namespace Tests\Application\Management\Doubles;
use org\bovigo\vfs\vfsStream;
use Milhojas\Infrastructure\Persistence\Management\PayrollFinder;
/**
* Description
*/
class PayrollFinderMock implements \IteratorAggregate
{
	private $files;
	
	function __construct()
	{
		$this->files = array(
			new \SplFileInfo(vfsStream::url('root/payroll/test/01_nombre_(apellido1 apellido2, nombre1 nombre2)_empresa_22308_trabajador_130496_030216_mensual.pdf')),
			new \SplFileInfo(vfsStream::url('root/payroll/test/02_nombre_(apellido3 apellido4, nombre3)_empresa_22308_trabajador_130286_010216_mensual.pdf')),
			new \SplFileInfo(vfsStream::url('root/payroll/test/03_nombre_(apellido1 apellido2, nombre1)_empresa_22308_trabajador_130296_030216_mensual.pdf'))
		);
	}
	
	public function getFiles($path)
	{
		return $this->files;
	}
	
	public function getIterator()
	{
		return new \ArrayIterator($this->files);
	}
}


?>