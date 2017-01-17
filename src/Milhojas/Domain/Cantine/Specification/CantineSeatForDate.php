<?php

namespace Milhojas\Domain\Cantine\Specification;

use Milhojas\Domain\Cantine\CantineList\CantineSeat;

class CantineSeatForDate implements CantineSeatSpecification
{
    /**
     * @var \DateTimeInterface
     */
    private $date;
    /**
     * @param \DateTimeInterface $date
     */
    public function __construct(\DateTimeInterface $date)
    {
        $this->date = $date;
    }

    /**
     * {@inheritdoc}
     */
    public function isSatisfiedBy(CantineSeat $cantineSeat)
    {
        return $cantineSeat->getDate() == $this->date;
    }
}
