<?php

namespace Milhojas\Domain\Utils\Schedule;

use Milhojas\Library\ValueObjects\Dates\MonthYear;
use Milhojas\Domain\Utils\Billing\BillingDaysCounter;
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
    public function countDays(BillingDaysCounter $counter)
    {
        throw new \LogicException('Not implemented'); // TODO
    }

    public function getDaysInMonth(MonthYear $month)
    {
        return 0;
    }

    /**
     * {@inheritdoc}
     */
    public function scheduledDays(Period $period)
    {
        throw new \LogicException('Not implemented'); // TODO
    }

    /**
     * {@inheritdoc}
     */
    public function realDays(Period $period)
    {
        throw new \LogicException('Not implemented'); // TODO
    }
}
