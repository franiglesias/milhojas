<?php

namespace Milhojas\UsersBundle\UserProvider;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;

class MilhojasUser implements UserInterface
{
    /**
     * @var string
     */
    protected $username;
	protected $fullName;
	protected $nickname;
	protected $firstName;
	protected $lastName;
	protected $avatar;
	
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

	static public function fromUserResponse(UserResponseInterface $UserResponse)
	{
		$user = new self($UserResponse->getUsername());
		$user->username = $UserResponse->getUsername();
		$user->fullName = $UserResponse->getRealName();
		$user->nickname = $UserResponse->getNickname();
		$user->firstName = $UserResponse->getFirstName();
		$user->lastName = $UserResponse->getLastName();
		$user->avatar = $UserResponse->getProfilePicture();
		return $user;
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
    public function isEqualTo(UserInterface $user)
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
	
	public function getFullName()
	{
		return $this->fullName;
	}
	
	public function getNickName()
	{
		return $this->nickname;
	}
	
	public function getFirstName()
	{
		return $this->firstName;
	}
	
	public function getLastName()
	{
		return $this->lastName;
	}
}

?>