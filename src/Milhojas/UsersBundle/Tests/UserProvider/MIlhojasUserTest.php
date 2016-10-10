<?php

namespace Tests\Milhojas\UsersBundle\UserProvider;

use Milhojas\UsersBundle\UserProvider\MilhojasUser;

class MilhojasUserTest extends \PHPUnit_Framework_Testcase {
	
	
	public function testInitUserWithEmail()
	{
		$username = 'test@example.com';
		$user = new MilhojasUser($username);
		$this->assertEquals($username, $user->getUsername());
	}
	
	public function testUserEqualityBasedOnUsername()
	{
		$user = new MilhojasUser('test@example.com');
		$otherUser = new MilhojasUser('test@example.com');
		$this->assertTrue($user->equals($otherUser));
		
		$differentUser = new MilhojasUser('other@example.com');
		$this->assertFalse($user->equals($differentUser));
	}
	
	public function testUserCanGetRoles()
	{
		$user = new MilhojasUser('test@example.com');
		$expected = array('ROLE_USER');
		$this->assertEquals($expected, $user->getRoles());
	}
	
	public function testWeCanAssignNewRolesToUser()
	{
		$user = new MilhojasUser('test@example.com');
		$user->assignNewRole('ROLE_BLOGGER');
		$expected = array('ROLE_USER', 'ROLE_BLOGGER');
		$this->assertEquals($expected, $user->getRoles());
	}
	
	public function testAssignNewRoleAcceptsArray()
	{
		$user = new MilhojasUser('test@example.com');
		$user->assignNewRole(['ROLE_BLOGGER', 'ROLE_EDITOR']);
		$expected = array('ROLE_USER', 'ROLE_BLOGGER', 'ROLE_EDITOR');
		$this->assertEquals($expected, $user->getRoles());
	}
	
	public function testAssignNewRoleIgnoresDuplicates()
	{
		$user = new MilhojasUser('test@example.com');
		$user->assignNewRole(['ROLE_BLOGGER', 'ROLE_USER']);
		$expected = array('ROLE_USER', 'ROLE_BLOGGER');
		$this->assertEquals($expected, $user->getRoles());
	}
	
}

?>