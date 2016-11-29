<?php

namespace Milhojas\Domain\Utils\Schedule;

/**
 * Represents a null schedule, if possible, it delegates to another schedule.
 * If not, it always return false.
 */
class NullSchedule extends Schedule
{
    /**
     * {@inheritdoc}
     */
    public function isScheduledDate(\DateTime $date)
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
}
