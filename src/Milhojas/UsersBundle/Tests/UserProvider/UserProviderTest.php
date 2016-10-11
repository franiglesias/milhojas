<?php

namespace Tests\Milhojas\UsersBundle\UserProvider;

/**
* We need a UserManager with SomeData
* We need a UserResponseInterface object with a valid response and an invalid one.
*/
use Milhojas\UsersBundle\Infrastructure\UserManager\InMemoryUserManager;
	
class UserProviderTest extends \PHPUnit_Framework_Testcase
{
	public function testItReturnsUserFromValidResponse()
	{
		# code...
	}
	
	public function testItThrowsExeceptionFormInvalidResponse()
	{
		# code...
	}
	
	public function testItThrowsExceptionForNotManagedDomains()
	{
		# code...
	}
	
	public function testItAddsUserIfValidButUnknown()
	{
		# code...
	}
	
	private function getUserManager()
	{
		$Manager = new InMemoryUserManager();
		$Manager->addUser(new MilhojasUser('user1@example.com'));
		$Manager->addUser(new MilhojasUser('user2@example.com'));
		$Manager->addUser(new MilhojasUser('user3@example.com'));
		return $Manager;
	}
	
	public function getValidUserResponse()
	{
		# code...
	}
	
	public function getInvalidUserResponse()
	{
		# code...
	}
	
	public function getValidUnknownUserResponse()
	{
		# code...
	}
	
	public function getInvalidDomainUserResponse()
	{
		# code...
	}
}


?>