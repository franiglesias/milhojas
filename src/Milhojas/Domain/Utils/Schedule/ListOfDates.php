<?php

namespace Milhojas\Domain\Utils\Schedule;

use Milhojas\Domain\Utils\Billing\BillingDaysCounter;
use League\Period\Period;

class ListOfDates extends Schedule implements \IteratorAggregate
{
    public function __construct($schedule)
    {
        foreach ((array) $schedule as $date) {
            $this->isValidDate($date);
            $this->schedule[] = $date;
        }
    }
    /**
     * {@inheritdoc}
     */
    public function isScheduledDate(\DateTimeInterface $date)
    {
        if (in_array($date, $this->schedule)) {
            return true;
        }

        return $this->delegate($date);
    }

    private function isValidDate($date)
    {
        if (!$date instanceof \DateTime) {
            throw new \InvalidArgumentException(sprintf('%s is not an object of type DateTime', $date));
        }
    }
    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->schedule);
    }
    /**
     * {@inheritdoc}
     */
    public function countDays(BillingDaysCounter $counter)
    {
        throw new \LogicException('Not implemented'); // TODO
    }

    /**
     * {@inheritdoc}
     */
    public function scheduledDays(Period $period)
    {
        throw new \LogicException('Not implemented'); // TODO
    }

    /**
     * {@inheritdoc}
     */
    public function realDays(Period $period)
    {
        throw new \LogicException('Not implemented'); // TODO
    }
}
