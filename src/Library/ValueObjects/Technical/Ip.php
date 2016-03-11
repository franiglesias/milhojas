<?php

namespace Milhojas\Library\ValueObjects\Technical;

/**
* Description
*/
class Ip
{
	private $ip;
	private $port;
	
	function __construct($ip, $port = false)
	{
		$this->isValid($ip);
		$this->ip = $ip;
		$this->port = $port;
	}
	
	public function getIp()
	{
		return $this->ip;
	}
	
	public function __toString()
	{
		return $this->ip;
	}
	
	protected function isValid($ip)
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
	
	public function isListening()
	{
		if (!$this->port) {
			return false;
		}
        if (! @fsockopen($this->ip, $this->port, $errno, $errstr, $timeout) )
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
	}
}

?>