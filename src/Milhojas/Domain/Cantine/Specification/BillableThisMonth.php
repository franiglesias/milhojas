<?php

namespace Milhojas\Domain\Cantine\Specification;

use League\Period\Period;
use Milhojas\Domain\Cantine\CantineUser;

class BillableThisMonth implements CantineUserSpecification
{
    private $period;

    public function __construct(Period $period)
    {
        $this->period = $period;
    }

    public function isSatisfiedBy(CantineUser $cantineUser)
    {
        return $cantineUser->isBillableOn($this->period);
    }
}
