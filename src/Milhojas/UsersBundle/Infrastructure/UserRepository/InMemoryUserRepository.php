<?php

namespace Milhojas\UsersBundle\Infrastructure\UserRepository;

use Milhojas\UsersBundle\Domain\User\UserRepositoryInterface;
/**
* Description
*/
class InMemoryUserRepository implements UserRepositoryInterface
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
