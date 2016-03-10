<?php

namespace Milhojas\Library\ValueObjects\Technical;

/**
* Description
*/
class Ip
{
	private $ip;
	
	function __construct($ip)
	{
		$this->isValid($ip);
		$this->ip = $ip;
	}
	
	public function getIp()
	{
		return $this->ip;
	}
	
	public function __toString()
	{
		return $this->ip;
	}
	
	public function isValid($ip)
	{
		if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
			throw new InvalidArgumentException(sprintf('%s is not a valid IP', $ip));
		}
	}
	
	public function isUp()
	{
		exec(sprintf('ping -c 1 -W 5 %s', escapeshellarg($this->ip)), $res, $rval);
		return $rval === 0;
	}
}

?>