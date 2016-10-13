<?php

namespace Milhojas\UsersBundle\Provider;

use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUserProvider;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use Milhojas\UsersBundle\Provider\OAuthUser;

class Provider extends OAuthUserProvider
{
    protected $session, $doctrine, $admins;
    public function __construct($session, $doctrine, $admins = array()) {
        $this->session = $session;
        $this->doctrine = $doctrine;
        $this->admins = $admins;
    }

    public function loadUserByUsername($username)
    {
        return new OAuthUser($username, $this->isUserAdmin($username)); //look at the class below
    }

    private function isUserAdmin($nickname)
    {
        return in_array($nickname, $this->admins);
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $nickname = $response->getNickname();
        $realname = $response->getRealName();
        $email    = $response->getEmail();

        $this->session->set('nickname', $nickname);
        $this->session->set('realname', $realname);
        $this->session->set('email', $email);
         return $this->loadUserByUsername($response->getNickname());
    }

	// This should be changed to match the User Class
    public function supportsClass($class)
    {
        return $class === 'Milhojas\\UsersBundle\\Provider\\OAuthUser';
    }
}


