<?php

namespace Milhojas\Library\ValueObjects\Identity;

/**
 * Represents a username
 *
 * @package default
 * @author Fran Iglesias
 */
class Username {
	
	private $username;
	private $domain;
	/**
	 * https://www.sanwebe.com/2012/07/get-only-domain-name-from-email-using-php
	 *
	 * @param string $username The username
	 * @author Fran Iglesias
	 */
	public function __construct($username)
	{
		$this->username = $username;
		$this->domain = substr(strrchr($this->username, "@"), 1);
	}

	/**
	 * Returns a string with the Username
	 *
	 * @return string
	 * @author Fran Iglesias
	 */
	public function get()
	{
		return $this->username;
	}
	
	/**
	 * Returns the domain of the username
	 *
	 * @return string
	 * @author Fran Iglesias
	 */
	public function getDomain()
	{
		return $this->domain;
	}
	
	/**
	 * Returns true if the user name belongs to one of the domains tested
	 *
	 * @param string/array $domain domain or array of domains to test against
	 * @return boolean
	 * @author Fran Iglesias
	 */
	public function belongsToDomain($domain)
	{
		return in_array($this->domain, (array)$domain);
	}
	
	/**
	 * Returns the string representation of the username
	 *
	 * @return string represnting the username
	 * @author Fran Iglesias
	 */
	public function __toString()
	{
		return $username;
	}
}

?>
