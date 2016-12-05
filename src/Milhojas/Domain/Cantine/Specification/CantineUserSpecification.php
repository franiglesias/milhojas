<?php

namespace Milhojas\Domain\Cantine\Specification;

use Milhojas\Domain\Cantine\CantineUser;

interface CantineUserSpecification
{
    public function isSatisfiedBy(CantineUser $cantineUser);
}
