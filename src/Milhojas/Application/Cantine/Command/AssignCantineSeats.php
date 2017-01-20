<?php

namespace Milhojas\Application\Cantine\Command;

use Milhojas\Messaging\CommandBus\Command;

/**
 * Process CantineUsers and assign the seats for the specified date.
 */
class AssignCantineSeats implements Command
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
     * @return \DateTimeInterface
     */
    public function getDate()
    {
        return $this->date;
    }
}
