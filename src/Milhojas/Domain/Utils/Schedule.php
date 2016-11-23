<?php

namespace Milhojas\Domain\Utils;

interface Schedule
{
    /**
     * Tells if the passed $date is scheduled.
     *
     * @param \DateTime $date
     *
     * @return bool true if scheduled
     */
    public function isScheduledDate(\DateTime $date);
    /**
     * Updates the schedule with another schedule of the same type.
     *
     * @param Schedule $delta
     *
     * @return Schedule a new instance with data merge
     */
    public function update(Schedule $delta);
}
