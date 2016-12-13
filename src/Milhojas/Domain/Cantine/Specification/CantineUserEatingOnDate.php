<?php

namespace Milhojas\Domain\Cantine\Specification;

use Milhojas\Domain\Cantine\Specification\CantineUserSpecification;
use Milhojas\Domain\Cantine\CantineUser;

class CantineUserEatingOnDate implements CantineUserSpecification
{
    private $date;
    public function __construct(\DateTimeInterface $date)
    {
        $this->date = $date;
    }

    public function isSatisfiedBy(CantineUser $cantineUser)
    {
        return $cantineUser->isEatingOnDate($this->date);
    }

}
