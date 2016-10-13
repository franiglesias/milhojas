<?php

namespace Tests\Application\Management\Doubles;

use Milhojas\Domain\Management\Payroll;
use Milhojas\Domain\Management\PayrollRepository;
use org\bovigo\vfs\vfsStream;

/**
* Simulates the Payroll Respository
*/

class PayrollRepositoryMock implements PayrollRepository {

	private $times;
	private $finder;
	private $root;
	
	private $responses;
	
	public function __construct($root, $finder)
	{
		$this->finder = $finder;
		$this->times = 0;
		$this->root = $root;
		$this->responses = array(
			1 => new Payroll(1, 'Name1 Lastname 1', 'email1@example.com', vfsStream::url('root/payroll/test/01_nombre_(apellido1 apellido2, nombre1 nombre2)_empresa_22308_trabajador_130496_030216_mensual.pdf'), 'male'),
			2 => new Payroll(2, 'Name2 Lastname 2', 'email2@example.com', vfsStream::url('root/payroll/test/02_nombre_(apellido3 apellido4, nombre3)_empresa_22308_trabajador_130286_010216_mensual.pdf'), 'female'),
			3 => new Payroll(3, 'Name3 Lastname 3', 'email3@example.com', vfsStream::url('root/payroll/test/03_nombre_(apellido1 apellido2, nombre1)_empresa_22308_trabajador_130296_030216_mensual.pdf'), 'male'),
 		);
	}
	
	public function get($file)
	{
		$this->times++;
		return $this->responses[$this->times];
	}
	
	public function getTimesCalled()
	{
		return $this->times;
	}
	
	public function getFiles($month)
	{
		$this->finder->getFiles($this->root.'/'.$month);
		return $this->finder;
	}
	
	public function count($month)
	{
		return $this->finder->count($month);
	}
}

?>
