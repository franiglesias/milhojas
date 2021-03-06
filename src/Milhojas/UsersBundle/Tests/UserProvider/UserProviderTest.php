<?php

namespace Milhojas\UsersBundle\Tests\UserProvider;

use Milhojas\UsersBundle\UserProvider\UserProvider;
use Milhojas\UsersBundle\UserProvider\User;
/**
* We need a UserRepository with SomeData
* We need a UserResponseInterface object with a valid response and an invalid one.
*/
use Milhojas\UsersBundle\Infrastructure\UserRepository\InMemoryUserRepository;
use Milhojas\UsersBundle\Infrastructure\UserRepository\YamlUserRepository;

use Milhojas\UsersBundle\Tests\UserProvider\Doubles\SessionDouble;
use Milhojas\UsersBundle\Tests\UserProvider\Doubles\UserResponseDouble;


class UserProviderTest extends \PHPUnit_Framework_Testcase
{
	public function testItReturnsUserFromValidResponse()
	{
		$UserProvider = new UserProvider($this->getUserRepository());
		$response = $this->getValidUserResponse();
		$user = $UserProvider->loadUserByOAuthUserResponse($response);
		$this->assertInstanceOf('\Milhojas\UsersBundle\UserProvider\User', $user);
		$this->assertEquals('frankie@miralba.org', $user->getUsername());
		$this->assertEquals('frankie@miralba.org', $user->getId());
	}
	
	/**
	 * @expectedException Symfony\Component\Security\Core\Exception\UsernameNotFoundException
	 */
	public function testItThrowsExceptionIfUserNotFound()
	{
		$UserProvider = new UserProvider($this->getUserRepository());
		$response = $this->getValidUnknownUserResponse();
		$user = $UserProvider->loadUserByOAuthUserResponse($response);
	}

	/**
	 * @expectedException Symfony\Component\Security\Core\Exception\UsernameNotFoundException
	 */
	public function testItThrowsExeceptionFormInvalidResponse()
	{
		$UserProvider = new UserProvider($this->getUserRepository());
		$response = $this->getInvalidUserResponse();
		$user = $UserProvider->loadUserByOAuthUserResponse($response);
	}

	/**
	 * @expectedException Milhojas\UsersBundle\Exceptions\UserBelongsToUnmanagedDomain
	 */
	public function testItThrowsExceptionForNotManagedDomains()
	{
		$UserProvider = new UserProvider($this->getUserRepository(), array('miralba.org'));
		$response = $this->getInvalidDomainUserResponse();
		$user = $UserProvider->loadUserByOAuthUserResponse($response);
	}
	
	public function testItAddsUserIfValidButUnknown()
	{
		# code...
	}
	
	public function getSession()
	{
		return new SessionDouble();
	}
	
	private function getUserRepository()
	{
		$Manager = new YamlUserRepository(getcwd().'/src/Milhojas/UsersBundle/Tests/Infrastructure/UserRepository/Fixtures/user_provider.yml');
		return $Manager;
	}
	
	public function getValidUserResponse()
	{
		$response = new UserResponseDouble();
		$response->username = 'frankie@miralba.org';
		$response->nickname = 'frankie@miralba.org';
		$response->firstName = 'Fran';
		$response->lastName = 'Iglesias';
		$response->realName = 'Fran Iglesias';
		$response->email = 'frankie@miralba.org';
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
		$response->username = 'profe@miralba.org';
		$response->nickname = 'profe@miralba.org';
		$response->firstName = 'Profesor';
		$response->lastName = 'Pruebas';
		$response->realName = 'Profesor Pruebas';
		$response->email = 'profe@miralba.org';
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
