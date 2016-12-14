<?php

namespace Milhojas\Domain\Cantine\Specification;

use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Library\ValueObjects\Dates\MonthYear;

class BillableThisMonth implements CantineUserSpecification
{
    private $month;

    public function __construct(MonthYear $month)
    {
        $this->month = $month;
    }

    public function isSatisfiedBy(CantineUser $cantineUser)
    {
        // code...
    }
}
