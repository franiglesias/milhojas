<?php

namespace Milhojas\Domain\Utils\Schedule;

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
        if (!$date instanceof \DateTimeInterface) {
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
    public function scheduledDays(Period $period)
    {
        return 0;
    }

    /**
     * {@inheritdoc}
     */
    public function realDays(Period $period)
    {
        $count = 0;
        foreach ($this->schedule as $date) {
            $count += $period->contains($date) ? 1 : 0;
        }

        return $count;
    }
}
