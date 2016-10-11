<?php

namespace Milhojas\UsersBundle\Tests\Infrastructure\UserManager;

use Milhojas\UsersBundle\Infrastructure\UserManager\InMemoryUserManager;
use Milhojas\UsersBundle\UserProvider\MilhojasUser;

class InMemoryUserManagerTest extends \PHPUnit_Framework_TestCase
{
	public function testItCanAddAUser()
	{
		$this->startWithEmptyManager();
		$this->populateWithUsers(1);
		$this->assertManagerContainsUsers(1);
	}
	
	public function testItCanAddSeveralUsers()
	{
		$this->startWithEmptyManager();
		$this->populateWithUsers(3);
		$this->assertManagerContainsUsers(3);
	}
	
	public function testItCanRetrieveAUserByEmail()
	{
		$this->startWithEmptyManager();
		$this->populateWithUsers(3);
		$this->assertManagerHoldsThisUser('user2@example.com');
	}
	
	# PRIVATE REGION #
	
	private function startWithEmptyManager()
	{
		$this->manager = new InMemoryUserManager();
	}
	
	private function populateWithUsers($quantity)
	{
		for ($i=1; $i <= $quantity; $i++) { 
			$this->manager->addUser(new MilhojasUser('user'.$i.'@example.com'));
		}
	}
	
	private function assertManagerContainsUsers($expectedQuantity)
	{
		$this->assertEquals($expectedQuantity, $this->manager->countAll());
	}
	
	private function assertManagerHoldsThisUser($username)
	{
		$User = $this->manager->getUser($username);
		$this->assertTrue($User->isEqualTo(new MilhojasUser($username)));
	}
}

?>