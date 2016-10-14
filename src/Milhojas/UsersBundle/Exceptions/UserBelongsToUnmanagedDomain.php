<?php

namespace Milhojas\UsersBundle\Exceptions;

use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
/**
* Auth Error beacause User belongs to a Domain Not Managed by this application
*/
class UserBelongsToUnmanagedDomain extends UnsupportedUserException
{
}

?>