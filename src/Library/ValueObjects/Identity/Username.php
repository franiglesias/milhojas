<?php

namespace Milhojas\Library\ValueObjects\Identity;

class Username {
	
	private $username;
	private $domain;
	/**
	 * https://www.sanwebe.com/2012/07/get-only-domain-name-from-email-using-php
	 *
	 * @param string $username 
	 * @author Fran Iglesias
	 */
	public function __construct($username)
	{
		$this->username = $username;
		$this->domain = substr(strrchr($this->username, "@"), 1);
	}

	public function get()
	{
		return $this->username;
	}
	
	public function getDomain()
	{
		return $this->domain;
	}
	
	public function belongsToDomain($domain)
	{
		return in_array($this->domain, (array)$domain);
	}
	
	public function __toString()
	{
		return $username;
	}
}

?>
