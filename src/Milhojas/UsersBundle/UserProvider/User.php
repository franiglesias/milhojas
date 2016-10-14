<?php

namespace Milhojas\UsersBundle\UserProvider;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;

class User implements UserInterface, EquatableInterface
{
    /**
     * @var string
     */
    protected $username;
	protected $fullName;
	protected $nickName;
	protected $firstName;
	protected $lastName;
	protected $avatar;
	protected $email;
	
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

	public function setUserName($username)
	{
		$this->username = $username;
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
	
	public function setId($id)
	{
		$this->username = $id;
	}
	public function getId()
	{
		return $this->username;
	}
	
	public function setFullName($fullName)
	{
		$this->fullName = $fullName;
	}
	public function getFullName()
	{
		return $this->fullName;
	}
	
	public function setNickName($nickName)
	{
		$this->nickName = $nickName;
	}
	public function getNickName()
	{
		return $this->nickName;
	}
	
	public function setFirstName($firstName)
	{
		$this->firstName = $firstName;
	}
	public function getFirstName()
	{
		return $this->firstName;
	}
	
	public function setLastName($lastName)
	{
		$this->lastName = $lastName;
	}
	public function getLastName()
	{
		return $this->lastName;
	}
	
	public function setEmail($email)
	{
		$this->email = $email;
	}
	public function getEmail()
	{
		return $this->email;
	}
	
	public function setAvatar($image)
	{
		$this->avatar = $image;
	}
	public function getAvatar()
	{
		return $this->avatar;
	}
}

?>
