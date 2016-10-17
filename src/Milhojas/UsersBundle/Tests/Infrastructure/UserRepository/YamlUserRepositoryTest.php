<?php

namespace Milhojas\UsersBundle\Tests\Infrastructure\UserRepository;

use Milhojas\UsersBundle\Infrastructure\UserRepository\YamlUserRepository;
use Milhojas\UsersBundle\UserProvider\User;

class YamlUserRepositoryTest extends \PHPUnit_Framework_TestCase
{
	private $testFile;
	
	public function setUp()
	{
		$this->testFile = getcwd().'/src/Milhojas/UsersBundle/Tests/Infrastructure/UserRepository/Fixtures/users.yml';
	}
	
	public function testItCanLoadUser()
	{
		$Manager = new YamlUserRepository($this->testFile);
		$User = $Manager->getUser('frankie@miralba.org');
		$this->assertEquals('frankie@miralba.org', $User->getUsername());
		$this->assertEquals(array('ROLE_USER', 'ROLE_ROOT'), $User->getRoles());
		$this->assertEquals('Fran Iglesias', $User->getFullName());
	}
	
	public function testItCanAddUser()
	{
		$Manager = new YamlUserRepository($this->testFile);
		$User = new User('new@example.com');
		$User->setEmail('new@example.com');
		$User->setFirstName('New');
		$User->setLastName('User');
		$Manager->addUser($User);
		$User = $Manager->getUser('new@example.com');
		$this->assertEquals('new@example.com', $User->getUsername());
	}
	
	public function testItCanRetrieveAllRecords()
	{
		$Manager = new YamlUserRepository($this->testFile);
		$all = $Manager->findAll();
		$expected = array(
			'frankie@miralba.org'=> [
			    'password'=> null,
			    'roles'=> ['ROLE_ROOT'],
			    'firstname'=> 'Fran',
			    'lastname'=> 'Iglesias',
				],
			'test@example.com'=>[
			    'password'=> null,
			    'roles'=> ['ROLE_USER', 'ROLE_APP'],
			    'firstname'=> 'Usuario',
			    'lastname'=> 'Pruebas',
				],
			'new@example.com'=>[
			    'firstname'=> 'New',
			    'lastname'=> 'User',
			    'roles'=> ['ROLE_USER']
				]
			);
		$this->assertEquals($expected, $all);
	}
}

?>
