<?php

namespace Milhojas\UsersBundle\UserProvider;

use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUserProvider;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use Milhojas\UsersBundle\UserProvider\MilhojasUser;
use Milhojas\UsersBundle\Domain\User\UserManagerInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class UserProvider extends OAuthUserProvider
{
    protected $session, $UserManager;
	
    public function __construct($session, UserManagerInterface $UserManager) {
        $this->session = $session;
		$this->UserManager = $UserManager;
    }

    public function loadUserByUsername($username)
    {
		if (!$this->UserManager->exists($username)) {
			throw new UsernameNotFoundException();
		}
		return $this->UserManager->getUser($username);
    }


    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
		// Load User Data From Response
		
		// Check Allowed Domain
		
		// Check Valid User
		
		// Data in session ???
		
		// Append User if valid but not in Manager???
		
        return $this->loadUserByUsername($response->getUsername());
    }

    public function supportsClass($class)
    {
		// This should be changed to match the User Class
        return $class === 'Milhojas\\UsersBundle\\UserProvider\\MilhojasUser';
    }
	
	private function getUserFromResponse(UserResponseInterface $response)
	{
		$User = new MilhojasUser($response->getUsername());
		$User->setEmail($response->getEmail());
		$User->setFirstName($response->getFirstName());
		$User->setLastName($response->getLastName());
		$User->setFullName($response->getRealName());
		$User->setAvatar($response->getProfilePicture());
		return $User;
	}
}


