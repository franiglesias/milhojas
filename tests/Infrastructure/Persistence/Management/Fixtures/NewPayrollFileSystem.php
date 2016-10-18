<?php

namespace Tests\Infrastructure\Persistence\Management\Fixtures;

use org\bovigo\vfs\vfsStream;

class NewPayrollFileSystem {
	
	private $root;
	
	public function __construct()
	{
		$structure = array(
			'staff.yml' => $this->loadStaffFile(),
			'test' => array(
				'01_nombre_(apellido1 apellido2, nombre1 nombre2)_empresa_22308_trabajador_130496_030216_mensual.pdf' => 'valid' ,
				'02_nombre_(apellido3 apellido4, nombre3)_empresa_22308_trabajador_130286_010216_mensual.pdf' => 'valid',
				'03_nombre_(apellido1 apellido2, nombre1)_empresa_22308_trabajador_130296_030216_mensual.pdf'=> 'valid single name',
				'04_nom_(apellido1 apellido2, nombre1)_empresa_22308_trabajador_130196_030216_mensual.pdf' => 'valid no name',
				'05_nombre_(apellido1 apellido2, nombre1)_empresa_22308_trabajador_45asdf_020216_mensual.pdf' => 'invalid id'
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
	
	private function loadStaffFile()
	{
		$file  = $this->encodeUser('email1@example.com', 'Nombre 1', 'Apellido 1', 'male', array(130496, 130296));
		$file .= $this->encodeUser('email2@example.com', 'Nombre 2', 'Apellido 2', 'female', array(130286));
		$file .= $this->encodeUser('email3@example.com', 'Nombre 3', 'Apellido 3', 'female', array(110000));
		return $file;
	}
	
	private function encodeUser($email, $firstname, $lastname, $gender, $payroll)
	{
		$pattern = '    %s:  \'%s\''.chr(10);
		$result  = $email.':'.chr(10);
		$result .= sprintf($pattern, 'username', $email);
		$result .= sprintf($pattern, 'email', $email);
		$result .= sprintf($pattern, 'firstname', $firstname);
		$result .= sprintf($pattern, 'lastname', $lastname);
		$result .= sprintf($pattern, 'gender', $gender);
		$result .= '    payroll: ['.implode(', ', $payroll).']'.chr(10);
		return $result;
	}
}

?>
