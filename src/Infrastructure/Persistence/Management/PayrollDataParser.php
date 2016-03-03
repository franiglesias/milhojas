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
		foreach (file($path) as $line) {
			list($id, $email, $gender) = explode(chr(9), $line);
			$this->data[$id] = array(
				'email' => trim($email),
				'gender' => trim($gender)
			);
		}
	}
	
	public function getData()
	{
		return $this->data;
	}
	
}

?>