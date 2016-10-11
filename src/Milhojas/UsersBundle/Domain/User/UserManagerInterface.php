<?php

namespace Milhojas\UsersBundle\Domain\User;

interface UserManagerInterface {
	public function addUser($User);
	public function getUser($username);
}

?>