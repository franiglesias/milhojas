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
    /**
     * Returns cantine user that meets $santineUserSpecification.
     *
     * @param CantineUserSpecification $cantineUserSpecification
     *
     * @return CantineUser the CantineUser or null
     */
    public function get(CantineUserSpecification $cantineUserSpecification);
    /**
     * Returns array of CantineUsers that meets $santineUserSpecification.
     *
     * @param CantineUserSpecification $cantineUserSpecification
     */
    public function find(CantineUserSpecification $cantineUserSpecification);
}
