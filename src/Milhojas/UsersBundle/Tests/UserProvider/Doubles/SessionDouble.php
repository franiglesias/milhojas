<?php

namespace Tests\Milhojas\UsersBundle\UserProvider\Doubles;

/**
* Mocks a simple Symfony Session object
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