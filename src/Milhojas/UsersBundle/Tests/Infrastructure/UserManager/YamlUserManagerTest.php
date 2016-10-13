<?php

namespace Milhojas\UsersBundle\Tests\Infrastructure\UserManager;

use Milhojas\UsersBundle\Infrastructure\UserManager\YamlUserManager;
use Milhojas\UsersBundle\UserProvider\MilhojasUser;

class YamlUserManagerTest extends \PHPUnit_Framework_TestCase
{
	public function testItCanLoadUser()
	{
		$Manager = new YamlUserManager('/Library/WebServer/Documents/milhojas/src/Milhojas/UsersBundle/Tests/Infrastructure/UserManager/Fixtures/users.yml');
		$User = $Manager->getUser('frankie@miralba.org');
		$this->assertEquals('frankie@miralba.org', $User->getUsername());
		$this->assertEquals(array('ROLE_USER', 'ROLE_ROOT'), $User->getRoles());
		$this->assertEquals('Fran Iglesias', $User->getFullName());
	}
	
	public function testItCanAddUser()
	{
		$Manager = new YamlUserManager('/Library/WebServer/Documents/milhojas/src/Milhojas/UsersBundle/Tests/Infrastructure/UserManager/Fixtures/users.yml');
		$User = new MilhojasUser('new@example.com');
		$User->setNickName('new@example.com');
		$User->setEmail('new@example.com');
		$User->setFirstName('New');
		$User->setLastName('User');
		$Manager->addUser($User);
		$User = $Manager->getUser('new@example.com');
		$this->assertEquals('new@example.com', $User->getUsername());
		
	}
}

?>