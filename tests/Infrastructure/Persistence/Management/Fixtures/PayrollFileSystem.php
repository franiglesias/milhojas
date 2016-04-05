<?php

namespace Tests\Infrastructure\Persistence\Management\Fixtures;

use org\bovigo\vfs\vfsStream;

class PayrollFileSystem {
	
	private $root;
	
	public function __construct()
	{
		$structure = array(
			'email.dat' => '130496'.chr(9).'email1@example.com'.chr(9).'male'.chr(10)
							.'130286'.chr(9).'email2@example.com'.chr(9).'female'.chr(10),
			'test' => array(
				'01_nombre_(apellido1 apellido2, nombre1 nombre2)_empresa_22308_trabajador_130496_030216_mensual.pdf' => 'valid' ,
				'02_nombre_(apellido3 apellido4, nombre3)_empresa_22308_trabajador_130286_010216_mensual.pdf' => 'valid',
				'03_nombre_(apellido1 apellido2, nombre1)_empresa_22308_trabajador_130296_030216_mensual.pdf'=> 'valid single name',
				'04_nom_(apellido1 apellido2, nombre1)_empresa_22308_trabajador_130196_030216_mensual.pdf' => 'no name',
				'05_nombre_(apellido1 apellido2, nombre1)_empresa_22308_trabajador_45asdf_020216_mensual.pdf' => 'no name'
			),
			'empty' => array()
		);
		$structure = array(
			// Path with a realistic file structure and contents
			'payroll' => $structure,
			// Path with no file structure or contents
			'alternative' => array(
				'noemail.dat' => 'empty'
			)
		);
		$this->root = vfsStream::setup('root', null, $structure);
	}
	
	public function get()
	{
		return $this->root;
	}
}

?>