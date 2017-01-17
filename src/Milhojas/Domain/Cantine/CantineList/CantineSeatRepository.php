<?php

namespace Milhojas\Domain\Cantine\CantineList;

use Milhojas\Domain\Cantine\Specification\CantineSeatSpecification;

interface CantineSeatRepository
{
    public function store(CantineSeat $cantineSeat);

    public function find(CantineSeatSpecification $cantineSeatSpecification);
}
