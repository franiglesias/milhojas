<?php

namespace Milhojas\UsersBundle\Tests\UserProvider;

use Milhojas\UsersBundle\UserProvider\MilhojasUser;

use Milhojas\UsersBundle\Tests\UserProvider\Doubles\UserResponseDouble;

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
		$this->assertTrue($user->isEqualTo($otherUser));
		
		$differentUser = new MilhojasUser('other@example.com');
		$this->assertFalse($user->isEqualTo($differentUser));
	}
	
	public function testUserCanGetRoles()
	{
		$user = new MilhojasUser('test@example.com');
		$user->assignNewRole('ROLE_USER');
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
	
	
}

?>