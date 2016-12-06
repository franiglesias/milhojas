<?php

namespace Milhojas\Domain\Cantine\Specification;

use Milhojas\Domain\Cantine\CantineUser;

interface CantineUserSpecification
{
    /**
     * @param CantineUser $cantineUser to test
     */
    public function isSatisfiedBy(CantineUser $cantineUser);
}
