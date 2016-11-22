<?php

namespace Milhojas\Domain\Cantine;

interface CantineUserRepository
{
    /**
     * Stores a Cantine User in the Repository.
     *
     * @param CantineUser $user
     */
    public function store(CantineUser $user);
    /**
     * @param mixed $id
     *
     * @return CantineUser A cantine user with the associated Id
     */
    public function retrieve($id);

    /**
     * Retrieve a list of users that is expecting to eat on $date.
     *
     * @param \DateTime $date
     */
    public function getUsersForDate(\DateTime $date);
}
