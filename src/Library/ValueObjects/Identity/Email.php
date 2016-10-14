<?php

namespace Milhojas\Library\ValueObjects\Identity;

/**
* Represents an Email
*/
class Email
{
	private $email;
	private $domain;
	
	function __construct($email)
	{
		$this->isValidEmail($email);
		$this->email = $email;
		$this->domain = substr(strrchr($this->email, "@"), 1);
	}
	
	public function get()
	{
		return $this->email;
	}
	
	public function getDomain()
	{
		return $this->domain;
	}
	
	private function isValidEmail($email)
	{
		if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
			throw new \InvalidArgumentException(sprintf('%s is an invalid email.', $email));
		} 
	}
	
	public function belongsToDomain($domain)
	{
		return in_array($this->domain, (array)$domain);
	}
	
	public function __toString()
	{
		return $this->email;
	}
}


?>
