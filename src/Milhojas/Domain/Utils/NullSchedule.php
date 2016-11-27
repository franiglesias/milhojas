<?php

namespace Milhojas\Domain\Utils;

class NullSchedule implements Schedule
{
    /**
     * {@inheritdoc}
     */
    public function isScheduledDate(\DateTime $date)
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function update(Schedule $delta)
    {
        return $delta;
    }
}
