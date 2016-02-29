<?php

namespace Tests\Infrastructure\Persistence\Management\Fixtures;

use org\bovigo\vfs\vfsStream;

class PayrollFileSystem {
	
	private $root;
	
	public function __construct()
	{
		$structure = array(
			'email.dat' => '130496_010216'.chr(9).'email1@example.com'.chr(13)
							.'130286_010216'.chr(9).'email2@example.com'.chr(13),
			'test' => array(
				'01_nombre_(apellido1 apellido2, nombre1 nombre2)_empresa_22308_trabajador_130496_010216_mensual.pdf' => 'valid' ,
				'02_nombre_(apellido3 apellido4, nombre3)_empresa_22308_trabajador_130286_010216_mensual.pdf' => 'valid',
				'03_nombre_(apellido1 apellido2, nombre1)_empresa_22308_trabajador_130296_010216_mensual.pdf'=> 'valid single name',
				'04_nom_(apellido1 apellido2, nombre1)_empresa_22308_trabajador_130196_010216_mensual.pdf' => 'no name'
			)
		);
		$this->root = vfsStream::setup('payroll', null, $structure);
	}
	
	public function get()
	{
		return $this->root;
	}
}

?>