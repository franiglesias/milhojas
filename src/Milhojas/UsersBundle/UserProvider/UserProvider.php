<?php

namespace Milhojas\UsersBundle\UserProvider;

use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUserProvider;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use Milhojas\UsersBundle\Domain\User\UserRepositoryInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class UserProvider extends OAuthUserProvider
{
	protected $UserRepository;
	protected $managedDomains;
	
    public function __construct(UserRepositoryInterface $UserRepository, $managedDomains = array()) {
		$this->UserRepository = $UserRepository;
		$this->managedDomains = $managedDomains;
    }

    public function loadUserByUsername($username)
    {
		$this->checkManagedDomain($username);
		$User = $this->UserRepository->getUser($username);
		if (!$User) {
			throw new UsernameNotFoundException(sprintf('User %s does not exists.', $username), 1);
		}
		return $User;
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        return $this->loadUserByUsername($response->getEmail());
    }

	// This should be changed to match the User Class
    public function supportsClass($class)
    {
        return $class === 'Milhojas\\UsersBundle\\UserProvider\\MilhojasUser';
    }
	
	# PRIVATE REGION #

	/**
	 * If $managedDomains is provided, checks the $username against the list and throws an Exception if domain is not managed
	 *
	 * @param string $username 
	 * @return void | Exception
	 * @author Fran Iglesias
	 */
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
	
	/**
	 * Extract domain from username (usually email)
	 *
	 * @param string $username 
	 * @return string user's domain
	 * @author Fran Iglesias
	 */
	private function extractDomain($username)
	{
		preg_match('/@(.+)$/', $username, $match);
		return $match[1];
	}
}


