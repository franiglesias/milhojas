<?php

namespace Milhojas\UsersBundle\Tests\UserProvider\Doubles;

/**
* Simulates a simple Symfony Session object
*/

class SessionDouble
{
	private $content;
	
	public function set($key, $value)
	{
		$this->content[$key] = $value;
	}
	
	public function get($key)
	{
		return $this->content[$key];
	}
}


?>
