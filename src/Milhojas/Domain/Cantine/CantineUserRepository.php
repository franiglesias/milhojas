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
}
