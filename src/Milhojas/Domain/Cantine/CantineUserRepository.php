<?php

namespace Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\Specification\CantineUserSpecification;

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
    public function get(CantineUserSpecification $cantineUserSpecification);
    public function find(CantineUserSpecification $cantineUserSpecification);
    /**
     * Retrieve a list of users that is expecting to eat on $date.
     *
     * @param \DateTime $date
     */
    public function getUsersForDate(\DateTime $date);
}
