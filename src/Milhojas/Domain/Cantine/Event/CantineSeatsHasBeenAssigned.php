<?php

namespace Milhojas\Domain\Cantine\Event;

use Milhojas\Domain\Cantine\CantineList\CantineList;
use Milhojas\Library\Messaging\EventBus\Event;

/**
 * Represents that Cantine Assignemente was performed for specified date.
 */
class CantineSeatsHasBeenAssigned implements Event
{
    /**
     * @var \DateTimeInterface
     */
    private $date;
    /**
     * @var CantineList
     */
    private $cantineList;

    /**
     * @param \DateTimeInterface $date
     * @param CantineList        $cantineList
     */
    public function __construct(
        \DateTimeInterface $date,
        CantineList $cantineList
    ) {
        $this->date = $date;
        $this->cantineList = $cantineList;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return CantineList
     */
    public function getCantineList()
    {
        return $this->cantineList;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'cantine.cantine_seats_has_been_assigned.event';
    }
}
