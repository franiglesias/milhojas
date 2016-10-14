<?php

namespace Milhojas\UsersBundle\Domain\User;

interface UserRepositoryInterface {
	public function addUser($User);
	public function getUser($username);
}

?>
