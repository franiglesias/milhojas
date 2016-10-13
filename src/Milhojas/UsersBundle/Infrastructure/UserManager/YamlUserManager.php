<?php

namespace Milhojas\UsersBundle\Infrastructure\UserManager;

use Milhojas\UsersBundle\Domain\User\UserManagerInterface;
use Milhojas\UsersBundle\UserProvider\MilhojasUser;


use Symfony\Component\Yaml\Yaml;

/**
* Description
*/
class YamlUserManager implements UserManagerInterface
{
	private $users;
	private $file;
	
	public function __construct($yaml_users_file)
	{
		$this->file = $yaml_users_file;
		$this->users = $this->loadUsers();
	}
	
	public function getUser($email) {
		$User = new MilhojasUser($email);
		$User->setEmail($email);
		$User->setFirstName($this->users[$email]['firstname']);
		$User->setLastName($this->users[$email]['lastname']);
		$User->setFullName($this->users[$email]['firstname'].' '.$this->users[$email]['lastname']);
		$User->assignNewRole($this->users[$email]['roles']);
		return $User;
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
}

?>