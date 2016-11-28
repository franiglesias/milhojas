<?php

namespace Milhojas\Domain\Utils;

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
     */
    public function update(Schedule $delta)
    {
        return $delta;
    }
}
