<?php

namespace Tests\Milhojas\UsersBundle\UserProvider;

use Milhojas\UsersBundle\UserProvider\UserProvider;
/**
* We need a UserManager with SomeData
* We need a UserResponseInterface object with a valid response and an invalid one.
*/
use Milhojas\UsersBundle\Infrastructure\UserManager\InMemoryUserManager;
use Tests\Milhojas\UsersBundle\UserProvider\Doubles\SessionDouble;
use Tests\Milhojas\UsersBundle\UserProvider\Doubles\UserResponseDouble as UserResponse;
	
class UserProviderTest extends \PHPUnit_Framework_Testcase
{
	public function testItReturnsUserFromValidResponse()
	{
		$UserProvider = new UserProvider($this->getSession(), $this->getUserManager());
		$respomse = $this->getValidUserResponse();
		$user = $UserProvider->loadUserByOAuthUserResponse($response);
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
	
	public function getSession()
	{
		return new SessionDouble();
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
		$response = new UserResponse();
		$response->username = 'user1@example.com';
		$response->nickname = 'User 1';
		$response->firstName = 'User 1';
		$response->lastName = 'Tests';
		$response->realName = 'User Tests 1';
		$response->email = 'user1@example.com';
		$response->picture = 'picture1.png';
		return $response;
	}
	
	public function getInvalidUserResponse()
	{
		$response = new UserResponse();
		return $response;
	}
	
	public function getValidUnknownUserResponse()
	{
		$response = new UserResponse();
		$response->username = 'user5@example.com';
		$response->nickname = 'User 5';
		$response->firstName = 'User 5';
		$response->lastName = 'Unknown';
		$response->realName = 'User Unknown 5';
		$response->email = 'user5@example.com';
		$response->picture = 'picture5.png';
		return $response;
	}
	
	public function getInvalidDomainUserResponse()
	{
		$response = new UserResponse();
		$response->username = 'user8@invalid.com';
		$response->nickname = 'User 8';
		$response->firstName = 'User 8';
		$response->lastName = 'Invalid';
		$response->realName = 'User Invalid 8';
		$response->email = 'user8@invalid.com';
		$response->picture = 'picture8.png';
		return $response;
	}
}


?>