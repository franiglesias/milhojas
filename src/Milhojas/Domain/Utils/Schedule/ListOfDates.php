<?php

namespace Milhojas\Domain\Utils\Schedule;

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
    public function isScheduledDate(\DateTime $date)
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
}
