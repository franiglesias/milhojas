<?php

namespace Milhojas\Domain\Cantine\Event;

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
     * @param \DateTimeInterface $date
     */
    public function __construct(
        \DateTimeInterface $date
    ) {
        $this->date = $date;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'cantine.cantine_seats_has_been_assigned.event';
    }
}
