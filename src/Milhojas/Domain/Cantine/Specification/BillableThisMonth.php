<?php

namespace Milhojas\Domain\Cantine\Specification;

use League\Period\Period;
use Milhojas\Domain\Cantine\CantineUser;

class BillableThisMonth implements CantineUserSpecification
{
    private $month;

    public function __construct(Period $month)
    {
        $this->month = $month;
    }

    public function isSatisfiedBy(CantineUser $cantineUser)
    {
        return $cantineUser->isBillableOn($this->month);
    }
}
