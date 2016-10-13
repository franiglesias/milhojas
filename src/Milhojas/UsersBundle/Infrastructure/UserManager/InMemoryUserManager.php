<?php

namespace Milhojas\UsersBundle\Infrastructure\UserManager;

use Milhojas\UsersBundle\Domain\User\UserManagerInterface;
/**
* Description
*/
class InMemoryUserManager implements UserManagerInterface
{
	private $users;
	
	public function __construct()
	{
		$this->users = [];
	}
	
	public function getUser($email) {
		return $this->users[$email];
	}
	
	public function addUser($User) {
		$this->users[$User->getId()] = $User;
	}
	
	public function countAll()
	{
		return count($this->users);
	}
}

?>

