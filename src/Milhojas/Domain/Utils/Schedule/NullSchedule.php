<?php

namespace Milhojas\Domain\Utils\Schedule;

use League\Period\Period;

/**
 * Represents a null schedule, if possible, it delegates to another schedule.
 * If not, it always return false.
 */
class NullSchedule extends Schedule
{
    /**
     * {@inheritdoc}
     */
    public function isScheduledDate(\DateTimeInterface $date)
    {
        return $this->delegate($date);
    }

    /**
     * {@inheritdoc}
     * It returns the passed Schedule so it "replaces" itself.
     */
    public function update(Schedule $delta)
    {
        return $delta;
    }

    /**
     * {@inheritdoc}
     */
    public function scheduledDays(Period $period)
    {
        if (!$this->next) {
            return 0;
        }

        return $this->next->scheduledDays($period);
    }

    /**
     * {@inheritdoc}
     */
    public function realDays(Period $period)
    {
        throw new \LogicException('Not implemented'); // TODO
    }
}
