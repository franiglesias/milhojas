<?php

namespace Milhojas\Domain\Utils\Schedule;

use League\Period\Period;

class WeeklySchedule extends Schedule
{
    public function __construct($weekDays)
    {
        foreach ((array) $weekDays as $weekDay) {
            $weekDay = strtolower($weekDay);
            $this->isValidWeekDay($weekDay);
            $this->schedule[] = $weekDay;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isScheduledDate(\DateTimeInterface $date)
    {
        $weekDay = strtolower($date->format('l'));

        if (in_array($weekDay, $this->schedule)) {
            return true;
        }

        return $this->delegate($date);
    }

    private function isValidWeekDay($weekDay)
    {
        if (!in_array($weekDay, ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'])) {
            throw new \InvalidArgumentException(sprintf('%s is not a valid week day', $weekDay));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function scheduledDays(Period $period)
    {
        return count($this->schedule);
    }

    /**
     * {@inheritdoc}
     */
    public function realDays(Period $period)
    {
        return count($this->schedule);
    }
}
