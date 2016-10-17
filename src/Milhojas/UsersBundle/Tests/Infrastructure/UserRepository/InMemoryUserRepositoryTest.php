<?php

namespace Milhojas\UsersBundle\Tests\Infrastructure\UserRepository;

use Milhojas\UsersBundle\Infrastructure\UserRepository\InMemoryUserRepository;
use Milhojas\UsersBundle\UserProvider\User;

class InMemoryUserRepositoryTest extends \PHPUnit_Framework_TestCase
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
	
	public function testItCanRetrieveAllRecords()
	{
		$this->manager = new InMemoryUserRepository();
		$this->populateWithUsers(4);
		$all = $this->manager->findAll();
		$this->assertEquals(4, count($all));
	}
	
	# PRIVATE REGION #
	
	private function startWithEmptyManager()
	{
		$this->manager = new InMemoryUserRepository();
	}
	
	private function populateWithUsers($quantity)
	{
		for ($i=1; $i <= $quantity; $i++) { 
			$this->manager->addUser(new User('user'.$i.'@example.com'));
		}
	}
	
	private function assertManagerContainsUsers($expectedQuantity)
	{
		$this->assertEquals($expectedQuantity, $this->manager->countAll());
	}
	
	private function assertManagerHoldsThisUser($username)
	{
		$User = $this->manager->getUser($username);
		$this->assertTrue($User->isEqualTo(new User($username)));
	}
}

?>
