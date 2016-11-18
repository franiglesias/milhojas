<?php

namespace Milhojas\Domain\Utils;

class RandomDaysSchedule implements Schedule
{
    /**
     * {@inheritdoc}
     */
    public function isScheduledDate(\DateTime $date)
    {
        throw new \LogicException('Not implemented'); // TODO
    }

    /**
     * {@inheritdoc}
     */
    public function update($delta_schedule)
    {
        throw new \LogicException('Not implemented'); // TODO
    }
}
