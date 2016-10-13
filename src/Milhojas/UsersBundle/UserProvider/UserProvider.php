<?php

namespace Milhojas\UsersBundle\UserProvider;

use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUserProvider;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use Milhojas\UsersBundle\UserProvider\MilhojasUser;
use Milhojas\UsersBundle\Domain\User\UserManagerInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class UserProvider extends OAuthUserProvider
{
    protected $session;
	protected $UserManager;
	protected $managedDomains;
	
    public function __construct($session, UserManagerInterface $UserManager, $managedDomains = array()) {
        $this->session = $session;
		$this->UserManager = $UserManager;
		$this->managedDomains = $managedDomains;
    }

    public function loadUserByUsername($username)
    {
		$this->checkManagedDomain($username);
		$User = $this->UserManager->getUser($username);
		if (!$User) {
			throw new UsernameNotFoundException(sprintf('User %s does not exists.', $username), 1);
		}
		return $User;
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        return $this->loadUserByUsername($response->getUsername());
    }

    public function supportsClass($class)
    {
		// This should be changed to match the User Class
        return $class === 'Milhojas\\UsersBundle\\UserProvider\\MilhojasUser';
    }
	
	# PRIVATE REGION #

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
	
	private function checkManagedDomain($username)
	{
		if (!$this->managedDomains) {
			return false;
		}
		$domain = $this->extractDomain($username);
		if (!in_array($domain, $this->managedDomains)) {
			throw new UnsupportedUserException(sprintf('Domain %s is not supported by this application.', $domain));
		}
	}
	
	private function extractDomain($username)
	{
		preg_match('/@(.+)$/', $username, $match);
		return $match[1];
	}
}


