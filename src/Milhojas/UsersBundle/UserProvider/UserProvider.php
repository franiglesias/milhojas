<?php

namespace Milhojas\UsersBundle\UserProvider;

use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUserProvider;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use Milhojas\UsersBundle\Domain\User\UserRepositoryInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Milhojas\UsersBundle\Exceptions\UserBelongsToUnmanagedDomain;

use Milhojas\Library\ValueObjects\Identity\Username;

class UserProvider extends OAuthUserProvider
{
	protected $UserRepository;
	protected $managedDomains;
	
    public function __construct(UserRepositoryInterface $UserRepository, $managedDomains = array()) {
		$this->UserRepository = $UserRepository;
		$this->managedDomains = $managedDomains;
    }

    public function loadUserByUsername($identifier)
    {
		$Username = new Username($identifier);
		$this->checkIfUserBelongsToManagedDomain($Username);
		$User = $this->UserRepository->getUser( $Username->get() );
		if (!$User) {
			throw new UsernameNotFoundException(sprintf('User %s does not exists.', $Username->get()), 1);
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
        return $class === 'Milhojas\\UsersBundle\\UserProvider\\User';
    }
	
	# PRIVATE REGION #

	/**
	 * If $managedDomains is provided, checks the $username against the list and throws an Exception if domain is not managed
	 *
	 * @param string $username 
	 * @return void | Exception
	 * @author Fran Iglesias
	 */
	private function checkIfUserBelongsToManagedDomain($Username)
	{
		if (! $this->managedDomains) {
			return false;
		}
		if (! $Username->belongsToDomain($this->managedDomains)) {
			throw new UserBelongsToUnmanagedDomain(sprintf('Domain %s is not supported by this application.', $Username->getDomain() ));
		}
	}
	
}


