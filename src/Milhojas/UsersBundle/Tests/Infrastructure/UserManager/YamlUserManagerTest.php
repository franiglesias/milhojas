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
}

?>