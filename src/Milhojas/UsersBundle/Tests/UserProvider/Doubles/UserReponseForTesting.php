<?php

namespace Tests\Milhojas\UsersBundle\UserProvider\Doubles;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;

/**
* Description
*/
class UserReponseForTesting implements UserResponseInterface
{
	
	function __construct()
	{
		# code...
	}
	
    /**
     * Get the unique user identifier.
     *
     * Note that this is not always common known "username" because of implementation
     * in Symfony2 framework. For more details follow link below.
     * @link https://github.com/symfony/symfony/blob/2.1/src/Symfony/Component/Security/Core/User/UserProviderInterface.php#L20-L28
     *
     * @return string
     */
    public function getUsername() { return null; }
    /**
     * Get the username to display.
     *
     * @return string
     */
    public function getNickname() { return null; }
    /**
     * Get the first name of user.
     *
     * @return null|string
     */
    public function getFirstName() { return null; }
    /**
     * Get the last name of user.
     *
     * @return null|string
     */
    public function getLastName() { return null; }
    /**
     * Get the real name of user.
     *
     * @return null|string
     */
    public function getRealName() { return null; }
    /**
     * Get the email address.
     *
     * @return null|string
     */
    public function getEmail() { return null; }
    /**
     * Get the url to the profile picture.
     *
     * @return null|string
     */
    public function getProfilePicture() { return null; }
    /**
     * Get the access token used for the request.
     *
     * @return string
     */
    public function getAccessToken() { return null; }
    /**
     * Get the access token used for the request.
     *
     * @return null|string
     */
    public function getRefreshToken() { return null; }
    /**
     * Get oauth token secret used for the request.
     *
     * @return null|string
     */
    public function getTokenSecret() { return null; }
    /**
     * Get the info when token will expire.
     *
     * @return null|string
     */
    public function getExpiresIn() { return null; }
    /**
     * Set the raw token data from the request.
     *
     * @param OAuthToken $token
     */
    public function setOAuthToken(OAuthToken $token) { return null; }
    /**
     * Get the raw token data from the request.
     *
     * @return OAuthToken
     */
    public function getOAuthToken() { return null; }	
	
}
?>