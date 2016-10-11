<?php

namespace Milhojas\UsersBundle\UserProvider;

use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUserProvider;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use Milhojas\UsersBundle\UserProvider\MilhojasUser;
use Milhojas\UsersBundle\Domain\User\UserManagerInterface;

class UserProvider extends OAuthUserProvider
{
    protected $session, $UserManager;
	
    public function __construct($session, UserManagerInterface $UserManager) {
        $this->session = $session;
		$this->UserManager = $UserManager;
    }

    public function loadUserByUsername($username)
    {
        return new MilhojasUser($username); //look at the class below
    }


    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
		// // Write data in session
		//
		// // Load an return user
		//
		//         //data from facebook response
		//         $googleId = $response->getUsername();
		//         $nickname = $response->getNickname();
		//         $realname = $response->getRealName();
		//         $email    = $response->getEmail();
		//         $avatar   = $response->getProfilePicture();
		//
		//         //set data in session
		// $this->session->set('id', $googleId);
		//         $this->session->set('nickname', $nickname);
		//         $this->session->set('realname', $realname);
		// $this->session->set('firstname', $this->getFirstName());
		// $this->session->set('lastname', $this->getLastName());
		//         $this->session->set('email', $email);
		//         $this->session->set('avatar', $avatar);
		//
		//         //get user by fid
		//         // $qb = $this->doctrine->getManager()->createQueryBuilder();
		//        //  $qb ->select('u.id')
		//        //      ->from('AcmeDemoBundle:User', 'u')
		//        //      ->where('u.fid = :fid')
		//        //      ->setParameter('fid', $facebook_id)
		//        //      ->setMaxResults(1);
		//        //  $result = $qb->getQuery()->getResult();
		//
		//         //add to database if doesn't exists
		//         // if ( !count($result) ) {
		//        //      $User = new User();
		//        //      $User->setCreatedAt(new \DateTime());
		//        //      $User->setNickname($nickname);
		//        //      $User->setRealname($realname);
		//        //      $User->setEmail($email);
		//        //      $User->setAvatar($avatar);
		//        //      $User->setFID($facebook_id);
		//        //
		//        //      $em = $this->doctrine->getManager();
		//        //      $em->persist($User);
		//        //      $id = $em->flush();
		//        //  } else {
		//        //      $id = $result[0]['id'];
		//        //  }
		//
		//         //set id
		//         // $this->session->set('id', $id);
		//
		//
		//         //parent:: returned value
        return $this->loadUserByUsername($response->getNickname());
    }

    public function supportsClass($class)
    {
		// This should be changed to match the User Class
        return $class === 'Milhojas\\UsersBundle\\UserProvider\\MilhojasUser';
    }
}


