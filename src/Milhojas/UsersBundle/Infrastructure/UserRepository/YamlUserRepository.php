<?php

namespace Milhojas\UsersBundle\Infrastructure\UserRepository;

use Milhojas\UsersBundle\Domain\User\UserRepositoryInterface;
use Milhojas\UsersBundle\UserProvider\User;


use Symfony\Component\Yaml\Yaml;

/**
* Description
*/
class YamlUserRepository implements UserRepositoryInterface
{
	private $users;
	private $file;
	
	public function __construct($yaml_users_file)
	{
		$this->file = $yaml_users_file;
		$this->users = $this->loadUsers();
	}
	
	public function getUser($email) {
		if ($this->userExists($email)) {
			return $this->readUser($email);
		}
		return false;
	}
	
	public function addUser($User) {
		$this->users[$User->getId()] = array(
			'firstname' => $User->getFirstName(),
			'lastname' => $User->getLastName(),
			'roles' => $User->getRoles()
		);
		$this->update();
	}
	
	public function countAll()
	{
		return count($this->users);
	}
	
	private function loadUsers()
	{
		$users = Yaml::parse(file_get_contents($this->file));
		return $users;
	}
	
	private function update()
	{
		$data = Yaml::dump($this->users);
		file_put_contents($this->file, $data);
	}
	
	private function readUser($email)
	{
		$User = new User($email);
		$User->setEmail($email);
		$User->setFirstName($this->users[$email]['firstname']);
		$User->setLastName($this->users[$email]['lastname']);
		$User->setFullName($this->users[$email]['firstname'].' '.$this->users[$email]['lastname']);
		$User->assignNewRole($this->users[$email]['roles']);
		return $User;
	}
	
	private function userExists($username)
	{
		if (isset($this->users[$username])) {
			return true;
		}
		return false;
	}
}

?>
