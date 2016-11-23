<?php

namespace Milhojas\Domain\Utils;

class WeeklySchedule implements Schedule
{
    private $schedule;

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
    public function isScheduledDate(\DateTime $date)
    {
        $weekDay = strtolower($date->format('l'));

        return in_array($weekDay, $this->schedule);
    }

    /**
     * {@inheritdoc}
     */
    public function update(Schedule $delta)
    {
        $update = array_merge($this->schedule, $delta->schedule);

        return new self($update);
    }

    private function isValidWeekDay($weekDay)
    {
        if (!in_array($weekDay, ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'])) {
            throw new \InvalidArgumentException(sprintf('%s is not a valid week day', $weekDay));
        }
    }
}
