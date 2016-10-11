<?php

namespace Milhojas\UsersBundle\Tests\UserProvider;

use Milhojas\UsersBundle\UserProvider\UserProvider;
use Milhojas\UsersBundle\UserProvider\MilhojasUser;
/**
* We need a UserManager with SomeData
* We need a UserResponseInterface object with a valid response and an invalid one.
*/
use Milhojas\UsersBundle\Infrastructure\UserManager\InMemoryUserManager;

use Milhojas\UsersBundle\Tests\UserProvider\Doubles\SessionDouble;
use Milhojas\UsersBundle\Tests\UserProvider\Doubles\UserResponseDouble;


class UserProviderTest extends \PHPUnit_Framework_Testcase
{
	public function testItReturnsUserFromValidResponse()
	{
		$UserProvider = new UserProvider($this->getSession(), $this->getUserManager());
		$response = $this->getValidUserResponse();
		$user = $UserProvider->loadUserByOAuthUserResponse($response);
		$this->assertInstanceOf('\Milhojas\UsersBundle\UserProvider\MilhojasUser', $user);
		$this->assertEquals('user1@example.com', $user->getUsername());
		$this->assertEquals('user1@example.com', $user->getId());
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
		$response = new UserResponseDouble();
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
		return new UserResponseDouble();
	}
	
	public function getValidUnknownUserResponse()
	{
		$response = new UserResponseDouble();
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
		$response = new UserResponseDouble();
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