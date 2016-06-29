<?php

namespace Milhojas\Infrastructure\Persistence\Management;

class PayrollDataParser {
	
	private $data;
	
	public function __construct()
	{
		$this->data = array();
	}
	
	public function createFromTab($path)
	{
		$this->dataFileExistsInFileSystem($path);
		foreach (file($path) as $line) {
			list($id, $email, $gender, $name, $last) = explode(chr(9), $line);
			$this->data[$id] = array(
				'email' => trim($email),
				'gender' => trim($gender),
				'name' => trim($name),
				'last' => trim($last)
			);
		}
	}
	
	public function getData()
	{
		return $this->data;
	}
	
	private function dataFileExistsInFileSystem($path)
	{
		if (! file_exists($path)) {
			throw new Exceptions\InvalidPayrollData(sprintf('There is not email.dat file in %s.', dirname($path)), 2);
		}
	}
	
	
}

?>