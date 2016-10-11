<?php

namespace Milhojas\UsersBundle\UserProvider;

use Symfony\Component\Security\Core\User\UserInterface;

class MilhojasUser implements UserInterface
{
    /**
     * @var string
     */
    protected $username;
	
	/**
	 * stores a list of roles assigned to this user
	 *
	 * @var string
	 */
	protected $roles;

    /**
     * @param string $username
     */
    public function __construct($username)
    {
        $this->username = $username;
		$this->roles = ['ROLE_USER'];
    }

    /**
     * {@inheritDoc}
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * {@inheritDoc}
     */
    public function getPassword()
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * {@inheritDoc}
     */
    public function eraseCredentials()
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function equals(UserInterface $user)
    {
        return $user->getUsername() === $this->username;
    }
	
	public function assignNewRole($role)
	{
		$this->roles = array_unique(array_merge($this->roles, (array) $role));
	}
	
	public function getId()
	{
		return $this->username;
	}
}

?>