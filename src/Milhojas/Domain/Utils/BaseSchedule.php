<?php

namespace Milhojas\Domain\Utils;

abstract class BaseSchedule implements Schedule
{
    private $next;
    protected $schedule;

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
    public function update(Schedule $delta)
    {
        throw new \LogicException('Not implemented'); // TODO
    }
}
