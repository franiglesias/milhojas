<?php

namespace Milhojas\Infrastructure\Persistence\Cantine;

use Milhojas\Domain\Cantine\CantineList\CantineSeat;
use Milhojas\Domain\Cantine\CantineList\CantineSeatRepository;
use Milhojas\Domain\Cantine\Specification\CantineSeatSpecification;

class CantineSeatInMemoryRepository implements CantineSeatRepository
{
    private $seats = [];
    /**
     * {@inheritdoc}
     */
    public function store(CantineSeat $cantineSeat)
    {
        $this->seats[] = $cantineSeat;
    }

    /**
     * {@inheritdoc}
     */
    public function find(CantineSeatSpecification $cantineSeatSpecification)
    {
        $found = [];
        foreach ($this->seats as $seat) {
            if ($cantineSeatSpecification->isSatisfiedBy($seat)) {
                $found[] = $seat;
            }
        }

        return $found;
    }
}
