<?php

namespace Milhojas\Domain\Cantine\Specification;

use Milhojas\Domain\Cantine\CantineList\CantineSeat;

interface CantineSeatSpecification
{
    public function isSatisfiedBy(CantineSeat $cantineSeat);
}
