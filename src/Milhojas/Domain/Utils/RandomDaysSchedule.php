<?php

namespace Milhojas\Domain\Utils;

class RandomDaysSchedule implements Schedule
{
    private $schedule;

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

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function update(Schedule $delta)
    {
        $newSchedule = array_merge($this->schedule, $delta->schedule);

        return new self($newSchedule);
    }

    private function isValidDate($date)
    {
        if (!$date instanceof \DateTime) {
            throw new \InvalidArgumentException(sprintf('%s is not an object of type DateTime', $date));
        }
    }
}
